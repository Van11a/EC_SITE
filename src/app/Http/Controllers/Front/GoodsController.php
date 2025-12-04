<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin\Category;
use App\Models\Admin\Goods;
use App\Http\Controllers\Controller;
use App\Services\Front\GoodsService;

class GoodsController extends Controller
{
    private $goodsService;

    public function __construct(GoodsService $goodsService)
    {
        $this->goodsService = $goodsService;
    }

    /**
     * 一覧画面
     */
    public function index(Request $request, $id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        $goods = $this->goodsService->searchGoodss($request,$id);
        return view('front.goods.index',compact('goods','id','category','categories','request'));
    }

    /**
     * 詳細画面
     */
    public function show($id) 
    {
        $goods = Goods::find($id);
        $category = Category::find($goods['category_id']);
        $categories = Category::all();
        return view('front.goods.show',compact('goods','category','categories'));
    }
}