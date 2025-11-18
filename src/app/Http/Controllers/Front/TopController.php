<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\Front\KeyVisualService;
use App\Services\Front\ProductService;
class TopController extends Controller
{
    private $keyVisualService;
    private $productService;
    public function __construct(KeyVisualService $keyVisualService, ProductService $productService)
    {
        $this->keyVisualService = $keyVisualService;
        $this->productService = $productService;
    }
    /**
     * 一覧画面
     */
    public function index() 
    {
        $key_visuals = $this->keyVisualService->displayKeyVisualsOnTheTopPage();
        $products = $this->productService->displayProductsOnTheTopPage();
        $categories = Category::all();
        return view('front.index',compact('key_visuals','products','categories'));
    }
}