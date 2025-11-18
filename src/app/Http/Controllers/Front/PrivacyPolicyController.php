<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
class PrivacyPolicyController extends Controller
{
    /**
     * 一覧画面
     */
    public function index() {
        $categories = Category::all();
        return view('front.privacypolicy.index',compact('categories'));
    }
}