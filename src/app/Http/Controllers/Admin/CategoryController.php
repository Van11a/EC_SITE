<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\NewRequest;
use App\Http\Requests\Admin\Category\EditRequest;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Services\Admin\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 一覧画面
     */
    public function index()
    {
        $categories = $this->categoryService->getAllParentCategories();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * 登録画面
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * 登録確認画面
     */
    public function create_confirm(NewRequest $request)
    {
        $category = $request->validated();
        return view('admin.category.create-confirm',compact('category'));
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        try {
            $create = $this->categoryService->createNewCategory($request);
            return redirect()->route('category.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('category.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput();
        }
    }

    /**
     * 編集処理
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * 編集確認処理
     */
    public function edit_confirm(Category $category, EditRequest $request)
    {
        $validated_data = $request->validated();
        $request->session()->flash('input_data', $validated_data);
        return view('admin.category.edit-confirm',compact('category'));
    }

    /**
     * 編集処理
     */
    public function update(Category $category, Request $request)
    {
        $validated_data = $request->session()->get('input_data');
        try{
            $this->categoryService->updateCategory($category,$validated_data);
            return redirect()->route('category.complete');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('category.index')->with([
                'message' => '保存に失敗しました'
            ])->withInput();
        }
    }

    /**
     * 完了画面
     */
    public function complete()
    {
        return view('admin.category.complete');
    }

    /**
     * 削除確認処理
     */
    public function destroy_confirm(Category $category)
    {
        return view('admin.category.destroy-confirm', compact('category'));
    }

    /**
     * 削除機能
     */
    public function destroy(Category $category)
    {
        try{
            $this->categoryService->deleteCategory($category);
            return view('admin.category.complete');
        } catch (\Throwable $e){
            report($e);
            return redirect()->route('category.index')->with([
                'message' => '削除に失敗しました'
            ])->withInput();
        }
    }
}