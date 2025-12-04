<?php
namespace App\Services\Admin;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\DB;
use App\Repositories\Admin\CategoryRepository;

class SubCategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllSubCategories(int $category_id)
    {
        return $this->categoryRepository->getAllSubCategoriesByParentId($category_id);
    }

    public function getSubCategory($id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function blankForms(int $count)
    {
        $blankForms = [];
        for($i = 0; $i < $count; $i++){
            $blankForms[] = new Category([
                'id' => null,
                'name' => '',
                'parent_id' => null,
            ]);
        }
        return $blankForms;
    }

    public function syncSubCategories(int $category_id, array $sub_categories)
    {
        DB::beginTransaction();
        try {
            foreach($sub_categories as $sub_category){
                $sub_category['parent_id'] = $category_id;
                if(empty($sub_category['id']) && !empty($sub_category['name'])){
                    //新規登録
                    $display_order = $this->generateNewDisplayOrder(); //表示順自動生成
                    $sub_category['display_order'] = $display_order;
                    $this->categoryRepository->create($sub_category);
                }elseif(!empty($sub_category['id']) && !empty($sub_category['name'])){
                    //更新処理
                    $this->categoryRepository->update($sub_category['id'],$sub_category);
                }elseif(!empty($sub_category['id']) && empty($sub_category['name'])){
                    //削除処理
                    $this->categoryRepository->destroy($sub_category['id']);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function generateNewDisplayOrder()
    {
        $max_display_order = Category::max('display_order');
        $new_display_order = $max_display_order + 1;
        return $new_display_order;
    }
}