<?php
namespace App\Services\Admin;
use App\Models\Admin\Goods;
use App\Repositories\Admin\GoodsRepository;

class GoodsService
{
    private $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
    }

    public function getAllGoods()
    {
        return $this->goodsRepository->getAll();
    }

    public function getGoods($id)
    {
        return $this->goodsRepository->getById($id);
    }
}