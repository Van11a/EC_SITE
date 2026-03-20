<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\Front\KeyVisualService;
use App\Services\Front\GoodsService;

class TopController extends Controller
{
    private $keyVisualService;
    private $goodsService;

    public function __construct(KeyVisualService $keyVisualService, GoodsService $goodsService)
    {
        $this->keyVisualService = $keyVisualService;
        $this->goodsService = $goodsService;
    }

    /**
     * 一覧画面
     */
    public function index()
    {
        $key_visuals = $this->keyVisualService->displayKeyVisualsOnTheTopPage();
        $goods = $this->goodsService->displayGoodsOnTheTopPage();
        $categories = Category::all();
        return view('front.index', compact('key_visuals', 'goods', 'categories'));
    }
}
