<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Requests\Front\TransferRequest;
use App\Models\Admin\Transfer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\Front\TransferService;
use App\Traits\Recaptcha;
class TransferController extends Controller
{
    use Recaptcha;
    private $transferService;
    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }
    /**
     * 振込情報入力画面
     */
    public function input_transfer() {
        return view('front.transfer.input-transfer');
    }
    /**
     * 振込情報確認画面
     */
    public function confirm_transfer(TransferRequest $request) {
        if($this->checkRecaptcha($request) === false){
            return redirect()->route('front-payment.input-transfer')->withErrors([
                'recapture' => 'ReCAPTCHAの検証に失敗しました',
            ]);
        }
        $request->validated();
        $transfer = $this->transferService->getTransferInfo($request['management_number']);
        $errors = $this->transferService->confirmValidTransferInfo($transfer);
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }
        $encryptedTranferId = $this->transferService->encryptTransferInfo($transfer->id);
        return view('front.transfer.confirm-transfer',compact('encryptedTranferId','transfer'));
    }
    /**
     * 決済情報入力画面
     */
    public function input_payment(Request $request) {
        $transfer = $this->transferService->decodeTransferInfo($request);
        $encryptedTranferId = $this->transferService->encryptTransferInfo($transfer->id);
        #ブラウザバック対策
        return response()->view('front.transfer.input-payment',compact('encryptedTranferId','transfer'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')->header('Pragma', 'no-cache')->header('Expires', '0');
    }
    /**
     * 決済情報完了画面
     */
    public function payment_completion(Request $request) {
        #振込IDを複合して振込情報を取得
        $transfer = $this->transferService->decodeTransferInfo($request);
        #決済処理
        $result = $this->transferService->executeTransferProcess($request, $transfer);
        #エラー時処理
        if(isset($result['credit_err'])) {
            return view('front.transfer.payment-completion',compact('result'));
        }
        return view('front.transfer.payment-completion',compact('transfer'));
    }
    /**
     * DGFTトークン取得
     */
    public function get_token(Request $request) {
        $token_api_key = env('TOKEN_API_KEY');
        echo $token_api_key;
        exit;
    }
}