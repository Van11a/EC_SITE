<?php
namespace App\Services\Admin;
use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
class CategoryService
{
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }
    public function getCategory($id)
    {
        return $this->categoryRepository->getById($id);
    }
}