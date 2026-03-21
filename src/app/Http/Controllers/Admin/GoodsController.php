<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Goods\NewRequest;
use App\Http\Requests\Admin\Goods\EditRequest;
use App\Models\Admin\Goods;
use App\Http\Controllers\Controller;
use App\Services\Admin\GoodsService;
use App\Services\Admin\CategoryService;

class GoodsController extends Controller
{
    private $goodsService;
    private $categoryService;

    public function __construct(GoodsService $goodsService, CategoryService $categoryService)
    {
        $this->goodsService = $goodsService;
        $this->categoryService = $categoryService;
    }

    /**
     * 一覧画面
     */
    public function index()
    {
        $goods = $this->goodsService->getAllGoods();
        return view('admin.goods.index', compact('goods'));
    }

    /**
     * 登録画面
     */
    public function create(Request $request)
    {
        // 確認画面から『戻る』ボタンで戻ってきた時用のセッション保存処理
        if ($request->isMethod('post')) {
            $request->flash();
        }

        $categories = $this->categoryService->getAllParentCategories();
        return view('admin.goods.create', compact('categories'));
    }

    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $validated_data = $request->validated();
        $categries = $this->categoryService->getAllCategories();
        $goods = $this->goodsService->uploadImageToTemporaryServer($validated_data, $request);
        return view('admin.goods.create-confirm', compact('goods', 'categries'));
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        try {
            $this->goodsService->createNewGoods($request);
            return redirect()->route('goods.complete');
        } catch (Exception $exception) {
            report($exception);
            return redirect()->route('goods.index')->with([
                'msg' => '保存に失敗しました'
            ])->withInput();
        }
    }

    /**
     * 編集処理
     */
    public function edit($id)
    {
        $goods = $this->goodsService->getGoods($id);
        return view('admin.goods.edit', compact('goods'));
    }

    /**
     * 編集確認処理
     */
    public function edit_confirm(Goods $goods, EditRequest $request)
    {
        $validated_data = $request->validated();
        $request->session()->flash('input_data', $validated_data);
        return view('admin.goods.edit-confirm', compact('goods'));
    }

    /**
     * 編集処理
     */
    public function update(Goods $goods, Request $request)
    {
        $validated_data = $request->session()->get('input_data');
        $this->goodsService->updateGoods($goods, $validated_data);
        return redirect()->route('goods.complete');
    }

    /**
     * 完了画面
     */
    public function complete()
    {
        return view('admin.goods.complete');
    }
}
