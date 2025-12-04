<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategory\SubCategoryRequest;
use Illuminate\Http\Request;
use App\Services\Admin\SubCategoryService;
use App\Models\Admin\category;

class SubCategoryController extends Controller
{
    private $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    /**
     * 一覧画面
     */
    public function index(Category $category)
    {
        $sub_categories = $this->subCategoryService->getAllSubCategories($category->id);
        $exist_subcategories = $sub_categories->isNotEmpty();

        //入力フォーム用処理
        $form_items = [];
        $form_count = 5;

        if (!$exist_subcategories) {
            $form_items = $this->subCategoryService->blankForms($form_count);
        } else {
            $count_sub_category = count($sub_categories);
            if($count_sub_category < $form_count){
                $not_enough_form_num = $form_count - $count_sub_category;
                $add_form_items = $this->subCategoryService->blankForms($not_enough_form_num);
                $form_items = $sub_categories->concat($add_form_items);
            }else{
                $form_items = $sub_categories;
            }
        }
        return view('admin.subcategory.index',compact('form_items','category'));
    }

    /**
     * 一括登録・更新確認画面
     */
    public function batch_update_confirm(SubCategoryRequest $request, Category $category)
    {
        // $sub_categories = [];
        // foreach($requests as $request){
        //     $sub_category = $request->validated();
        //     $sub_categories[] = $sub_category;
        // }
        $validated_data = $request->validated(); 
        $request->session()->flash('input_data', $validated_data['sub_categories']);
        $sub_categories = $validated_data;

        // $sub_category = $request->validated();
        return view('admin.subcategory.batch_update_confirm',compact('sub_categories','category'));
    }

    /**
     * 一括登録・更新
     */
    public function batch_update(SubCategoryRequest $request, Category $category)
    {   
        // $form_data = $request->validated(); 
        $this->subCategoryService->syncSubCategories($category->id, $request['sub_categories']); 
        return redirect()->route('sub_category.complete',$category);
    }

    /**
     * 完了画面
     */
    public function complete(Category $category)
    {
        return view('admin.subcategory.complete',compact('category'));
    }

}