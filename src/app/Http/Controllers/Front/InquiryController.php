<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Requests\Front\InquiryRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Category;
use App\Models\Front\Inquiry;
use App\Services\Front\InquiryService;
class InquiryController extends Controller
{
    private $inquiryService;
    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
    }
    /**
     * 入力画面
     */
    public function index(Request $request) {
        $categories = Category::all();
        return view('front.inquiry.index',compact('request','categories'));
    }
    /**
     * 確認画面
     */
    public function confirm(InquiryRequest $request) {
        $categories = Category::all();
        $inquiry = $request->validated();
        return view('front.inquiry.confirm',compact('inquiry','categories'));
    }
    /**
     * 送信処理
     */
    public function send(InquiryRequest $request) {
        $categories = Category::all();
        try{
            $this->inquiryService->sendInquirydNotificationMails($request);
            return view('front.inquiry.complete',compact('categories'));
        } catch (\Throwable $e) {
            report($e);
            Log::info($request);
            return redirect()->route('front-inquiry.index')->with([
                'message' => '送信に失敗しました'
            ])->withInput(); 
        }
    }
    /**
     * 送信完了画面
     */
    public function complete() {
        $categories = Category::all();
        return view('front.inquiry.complete',compact('categories'));
    }
}