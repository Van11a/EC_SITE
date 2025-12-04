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
        return $this->category->whereNull('parent_id')
                       ->orderBy('display_order')
                       ->paginate(15);
    }

    public function getAllSubCategoriesByParentId(int $category_id)
    {
        return $this->category->where('parent_id', $category_id)
                       ->orderBy('display_order')
                       ->get();
    }

    public function getById(int $id)
    {
        return $this->category->find($id);
    }

    public function getByQuery($query)
    {
        return $query->paginate(10);
    }

    public function create(array $data)
    {
        return $this->category->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->category->where('id', $id)->update($data);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}