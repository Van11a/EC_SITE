<?php
namespace App\Traits;
use Illuminate\Support\Facades\Log;
//リキャプチャ用のトレイト
trait Recaptcha
{
    /**
     *  reCaptchaのBot判定
     *
     *  @return boolean
     */
    private function checkRecaptcha($request): bool 
    {
        $recaptcha_response = $request->input('recaptcha_token');
        $secret_key = env('RECAPTCHA_SECRET_KEY');
        $api_endpoint = env('RECAPTCHA_API_ENDPOINT').'?secret='.$secret_key.'&response='.$recaptcha_response;
        $api_response = file_get_contents($api_endpoint);
        $respons_data = json_decode($api_response);
        Log::channel('recaptcha')->info("transfer_authentication".print_r($respons_data,true));
        $error = isset($respons_data->{'error-codes'}) ? $respons_data->{'error-codes'} : [];
        if ($respons_data->success && $respons_data->score >= env('THRESHOLD') ) {
            //成功
            return true;
        }
        if(count($error) === 1 && $error[0] === 'timeout-or-duplicate') {
            //5分間のトークンタイムアウトも成功とする。
            return true;
        }
        //失敗時のみレスポンスのログを記録
        Log::channel('recaptcha')->info("transfer_authentication_failure:".print_r($respons_data,true));
        return false;
    }
}