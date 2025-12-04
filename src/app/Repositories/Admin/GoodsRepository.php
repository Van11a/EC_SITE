<?php
namespace App\Repositories\Admin;
use App\Models\Admin\Goods;

class GoodsRepository
{
    protected $goods;

    public function __construct(Goods $goods)
    {
        $this->goods = $goods;
    }

    public function getById($id)
    {
        return $this->goods->find($id);
    }

    public function getAll()
    {
        return $this->goods->paginate(10);
    }

    public function create(array $data)
    {
        return $this->goods->create($data);
    }

    public function update(Goods $goods, array $data)
    {
        return $goods->update($data);
    }
}