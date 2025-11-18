<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\NewRequest;
use App\Http\Requests\Admin\Product\EditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\Admin\ProductService;
use App\Services\Admin\CategoryService;
class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }
    /**
     * 一覧画面
     */
    public function index(Request $request)
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            $products = $this->productService->searchProducts($request);
            return view('admin.product.index',compact('products','categories','request'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
    /**
     * 登録画面
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.product.create',compact('categories'));
    }
    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $category = $this->categoryService->getCategory($request['category_id']);
        if(!isset($request['copy_image1'])){
            $request->validate(['image1' => 'required']);
        }
        $product = $request->validated();
        $product = $this->productService->uploadImageToTemporaryServer($request,$product);
        return view('admin.product.create-confirm',compact('product','category'));
    }
    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        try {
            $create = $this->productService->createNewProduct($request);
            return redirect()->route('product.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('product.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput();
        }
    }
    /**
     * 編集処理
     */
    public function edit($id)
    {
        $categories = $this->categoryService->getAllCategories();
        $product = $this->productService->getProduct($id);
        return view('admin.product.edit', compact('product','categories'));
    }
    /**
     * 編集確認処理
     */
    public function edit_confirm(EditRequest $request, $id)
    {
        $category = $this->categoryService->getCategory($request['category_id']);
        $product = $request->validated();
        $product['id'] = intval($request['id']);
        $product = $this->productService->uploadImageToTemporaryServer($request,$product);
        return view('admin.product.edit-confirm', compact('product','category'));
    }
    /**
     * 編集処理
     */
    public function update(Request $request, $id)
    {
        try{
            $this->productService->updateProduct($request,$id);
            return redirect()->route('product.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('product.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput();
        }
    }
    /**
     * 詳細画面
     */
    public function show($id)
    {
        $product = $this->productService->getProduct($id);
        $category = $this->categoryService->getCategory($product['category_id']);
        return view('admin.product.show', compact('product','category'));
    }
    /**
     * 完了画面
     */
    public function complete()
    {
        $this->productService->deleteImagesOnTemporaryServer();
        return view('admin.product.complete');
    }
    /**
     * 削除確認処理
     */
    public function destroy_confirm($id)
    {
        $product = $this->productService->getProduct($id);
        $category = $this->categoryService->getCategory($product['category_id']);
        return view('admin.product.destroy-confirm', compact('product','category'));
    }
    /**
     * 削除機能
     */
    public function destroy($id)
    {
        try{
            $this->productService->destroyProduct($id);
            return view('admin.product.complete');
        } catch (\Throwable $e){
            report($e);
            return redirect()->route('product.index')->with([
                'message' => '削除に失敗しました'
            ])->withInput();
        }
    }
    /**
     * 複製機能
     */
    public function copying($id)
    {
        $categories = $this->categoryService->getAllCategories();
        $product = $this->productService->getProduct($id);
        return view('admin.product.create', compact('product','categories'));
    }
}