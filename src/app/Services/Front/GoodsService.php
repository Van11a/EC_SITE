<?php

namespace App\Services\Front;

use App\Models\Admin\Goods;
use App\Repositories\Front\GoodsRepository;

class GoodsService
{
    private $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
    }

    public function displayGoodsOnTheTopPage()
    {
        $now_date = date('Y-m-d H:i:s');
        $query = Goods::where('deleted_at', NULL)->where('is_display', 1)->where('is_reccomend', 1)->orderBy('updated_at', 'desc');
        $query->where(function ($query) use ($now_date) {
            $query->where(function ($query) {
                $query->where('public_start_date', NULL)->where('public_end_date', NULL);
            })->Orwhere(function ($query) use ($now_date) {
                $query->where('public_start_date', '<=', $now_date)->where('public_end_date', NULL);
            })->Orwhere(function ($query) use ($now_date) {
                $query->where('public_start_date', NULL)->where('public_end_date', '>=', $now_date);
            })->Orwhere(function ($query) use ($now_date) {
                $query->where('public_start_date', '<=', $now_date)->where('public_end_date', '>=', $now_date);
            });
        });
        return $this->goodsRepository->getByQuery($query);
    }

    public function searchGoodss($id)
    {
        $now_date = date('Y-m-d H:i:s');
        $query = Goods::where('category_id', $id)->where('deleted_at', NULL)->where('is_display', 1);
        $query->where(function ($query) use ($now_date) {
            $query->where(function ($query) {
                $query->where('public_start_date', NULL)->where('public_end_date', NULL);
            })->Orwhere(function ($query) use ($now_date) {
                $query->where('public_start_date', '<=', $now_date)->where('public_end_date', NULL);
            })->Orwhere(function ($query) use ($now_date) {
                $query->where('public_start_date', NULL)->where('public_end_date', '>=', $now_date);
            })->Orwhere(function ($query) use ($now_date) {
                $query->where('public_start_date', '<=', $now_date)->where('public_end_date', '>=', $now_date);
            });
        });

        return $this->goodsRepository->getByQuery($query);
    }
}
