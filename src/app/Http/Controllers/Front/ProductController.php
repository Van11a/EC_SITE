<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Http\Controllers\Controller;
use App\Services\Front\ProductService;
class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * 一覧画面
     */
    public function index(Request $request, $id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        $products = $this->productService->searchProducts($request,$id);
        return view('front.product.index',compact('products','id','category','categories','request'));
    }
    /**
     * 詳細画面
     */
    public function show($id) 
    {
        $product = Product::find($id);
        $category = Category::find($product['category_id']);
        $categories = Category::all();
        return view('front.product.show',compact('product','category','categories'));
    }
}