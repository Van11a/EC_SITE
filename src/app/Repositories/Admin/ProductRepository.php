<?php
namespace App\Repositories\Admin;
use App\Models\Admin\Product;
class ProductRepository
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function getById($id)
    {
        return $this->product->find($id);
    }
    public function getByQuery($query)
    {
        return $query->paginate(10);
    }
    public function create(array $data)
    {
        return $this->product->create($data);
    }
    public function update(array $data, $id)
    {
        return $this->product->where('id', $id)->update($data);
    }
    public function destroy($id)
    {
        return $this->product->destroy($id);
    }
}