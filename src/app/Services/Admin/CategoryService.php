<?php

namespace App\Services\Admin;

use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Support\Arr;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategory();
    }

    public function getAllParentCategories()
    {
        return $this->categoryRepository->getAllParentCategory();
    }

    public function getCategory($id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function createNewCategory($request)
    {
        $display_order = $this->generateNewDisplayOrder(); //表示順自動生成
        $data = $request->only(['name', 'parent_id']);
        $data['display_order'] = $display_order;
        $this->categoryRepository->create($data);
    }

    public function updateCategory(Category $category, array $request)
    {
        $data = Arr::only($request, ['name', 'parent_id']);
        $this->categoryRepository->update($category, $data);
    }

    public function generateNewDisplayOrder()
    {
        $max_display_order = Category::max('display_order');
        $new_display_order = $max_display_order + 1;
        return $new_display_order;
    }

    public function deleteCategory(Category $category)
    {
        $this->categoryRepository->delete($category);
    }
}
