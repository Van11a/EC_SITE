<?php
namespace App\Repositories\Admin;
use App\Models\Admin\Category;
class CategoryRepository
{
    protected $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function getAll()
    {
        return $this->category->all();
    }
    public function getById($id)
    {
        return $this->category->find($id);
    }
}