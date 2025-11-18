<?php
namespace App\Services\Front;
use App\Models\Admin\Transfer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use tgMdk\dto\CardAuthorizeRequestDto;
use tgMdk\TGMDK_Transaction;
use Illuminate\Support\Str;
use App\Repositories\Front\TransferRepository;
use Illuminate\Support\Facades\Mail;
class TransferService
{
    private $transferRepository;
    public function __construct(TransferRepository $transferRepository)
    {
        $this->transferRepository = $transferRepository;
    }  
    public function getTransferInfo($management_number)
    {
        return $this->transferRepository->getByManagementNumber($management_number);
    }
    public function confirmValidTransferInfo($request)
    {
        $errors = [];
        
        if ($request->status == 1 && isset($request->settlement_number)) {
            $errors['management_number'] = 'すでにお支払いが完了しています。';
        }
        if ($request->status == 99){
            $errors['management_number'] = '管理者までお問い合わせください。<a href='.env('SITE_URL').'inquiry>お問い合わせはこちら</a>';
        }
        if (isset($request->settlement_token) && explode('-',$request->settlement_token)[1] + 60 > time()){
            $errors['management_number'] = 'しばらく時間を置いてから再度お試しいただきますようお願いいたします。';
        }
        return $errors;
    }
   
    public function encryptTransferInfo($id)
    {
       return Crypt::encryptString($id);
    }
    public function decodeTransferInfo($request)
    {
        try{
            $decryptedTranferId = Crypt::decryptString($request->input('transfer_id'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect('/');
        }
        $transfer = $this->transferRepository->getById($decryptedTranferId);
        #決済管理情報が取得できなかった場合トップページへ戻す
        if(!isset($transfer))
        {   
            Log::error($e->getMessage());
            return redirect('/');
        }
        return $transfer;
    }
    public function executeTransferProcess($request, $transfer)
    {
        #決済を行う
        define('TXN_FAILURE_CODE', 'failure');
        define('TXN_PENDING_CODE', 'pending');
        define('TXN_SUCCESS_CODE', 'success');
        define('TRUE_FLAG_CODE', 'true');
        define('FALSE_FLAG_CODE', 'false');
        require base_path('vendor/veritrans/tgmdk/src/tgMdk/3GPSMDK.php');
        /**
         * 取引ID
         */
        $order_id = $transfer['id']. '-'. date('ymdHis'). env('CODE');
        /**
         * 支払金額
         */
        $payment_amount = $transfer['settlement_amount'];
        /**
         * トークン
         */
        $token = @$_POST["token"];
        /**
         * 与信方法
         */
        $is_with_capture = TRUE_FLAG_CODE; //即時売上
        /**
         * 支払オプション
         */
        $jpo = 10; //一括払い
        /**
         * 必須パラメータ値チェック
         */
        if (empty($order_id)) {
            $status_id = 99;
            $credit_err = true;
            $credit_err_msg = "必須項目：取引IDが指定されていません";
            Log::channel('payment_failure')->info('Exception Error OrderId:'.$order_id);
        } else if (empty($payment_amount)) {
            $status_id = 99;
            $credit_err = true;
            $credit_err_msg = "必須項目：金額が指定されていません";
            Log::channel('payment_failure')->info('Exception Error OrderId:'.$order_id);
        }
        if(isset($credit_err)) {
            return $this->confirmPaymentError($credit_err_msg,$credit_err,$status_id);
        }
        /**
         * 要求電文パラメータ値の指定
         */
        $request_data = new CardAuthorizeRequestDto();
        $request_data->setOrderId($order_id);
        $request_data->setAmount($payment_amount);
        $request_data->setToken($token);
        $request_data->setWithCapture($is_with_capture);
        if (isset($jpo)) {
            $request_data->setJpo($jpo);
        }
        /**
         * 実施
         */
        $transaction = new TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        //予期しない例外
        if (!isset($response_data)) {
            $status_id = 99;
            $credit_err = true;
            $credit_err_msg = "取引の処理に失敗しました。";
            Log::channel('payment_failure')->info('Exception Error OrderId:'.$order_id);
        } else {
            /**
             * 取引ID取得
             */
            $result_order_id = $response_data->getOrderId();
            /**
             * 結果コード取得
             */
            $txn_status = $response_data->getMStatus();
            /**
             * 詳細コード取得
             */
            $txn_result_code = $response_data->getVResultCode();
            /**
             * エラーメッセージ取得
             */
            $error_message = $response_data->getMerrMsg();
            /**
             * センター応答日時
             */
            $cnter_request_date = $response_data->getCenterRequestDate();
            //処理失敗
            if (TXN_SUCCESS_CODE !== $txn_status) {
                $status_id = 2;
                $credit_err = true;
                $errData[] = "ErrCode:".$txn_status." ErrInfo:".$txn_result_code." ErrMsg:".$error_message;
                $credit_err_msg = $error_message;
                $transfer_date = NULL;
                //決済失敗時用のトークン生成
                $timestamp = time();
                $transfer['settlement_token'] = Str::random(32) . '-' . $timestamp;
                Log::channel('payment_failure')->info('Error OrderId:'.$order_id.' '.implode(" / ", $errData));
            //処理成功
            } else {
                $status_id = 1;
                $transfer_date = date('Y-m-d H:i', strtotime($cnter_request_date));
                Log::channel('payment_success')->info('Credit Result OrderId:'.$order_id.' CnterRequestDate:'.$cnter_request_date);
            }
        }
        //多重送信対策
        $request->session()->regenerateToken();
        $this->updateTransferInfo($transfer,$status_id,$transfer_date,$order_id);
        if(isset($credit_err)) {
            return $this->confirmPaymentError($credit_err_msg,$credit_err,$status_id);
        }
        #決済完了後のメール送信処理
        $this->sendPaymentCompletionEmailToAdministrator($transfer);
        $this->sendPaymentCompletionEmailToUser($transfer);
    }
    public function updateTransferInfo($transfer,$status_id,$transfer_date,$order_id)
    {
        $transfer['status'] = $status_id;
        if($status_id == 1) {
            $transfer['settlement_token'] = NULL;
            $transfer['payment_date'] = $transfer_date;
            $transfer['settlement_number'] = $order_id;
        }
        $get_data = $this->transferRepository->save($transfer);
        if (!$get_data) {
            echo('振込情報の登録に失敗しました。管理者までお問い合わせください。');
            exit();
        }
    }
    public function sendPaymentCompletionEmailToAdministrator($transfer)
    {
        Mail::send('front.transfer.admin-mail', [
            'transfer' => $transfer,
        ], function ($message) use ($transfer) {
            $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'))
                ->to(env('MAIL_FROM_ADDRESS'))
                ->subject('振込完了通知を受け付けました');
        });
    }
    public function sendPaymentCompletionEmailToUser($transfer)
    {
        Mail::send('front.transfer.mail', [
            'transfer' => $transfer,
        ], function ($message) use ($transfer) {
            $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'))
                ->to($transfer['email'])
                ->subject('振込完了のお知らせ');
        });
    }
    public function confirmPaymentError($credit_err_msg,$credit_err,$status_id)
    {
        return [
                'credit_err_msg' => $credit_err_msg,
                'credit_err' => $credit_err,
                'status_id' => $status_id
            ];
    }
}