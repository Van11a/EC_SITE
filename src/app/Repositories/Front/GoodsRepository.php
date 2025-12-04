<?php
namespace App\Repositories\Front;
use App\Models\Admin\Goods;

class GoodsRepository
{
    protected $goods;

    public function __construct(Goods $goods)
    {
        return $this->goods = $goods;
    }

    public function getByQuery($query)
    {
        return $query->orderBy('amount', 'asc')->paginate(6);
    }
}