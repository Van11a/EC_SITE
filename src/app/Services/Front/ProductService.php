<?php
namespace App\Services\Front;
use App\Models\Admin\Product;
use App\Repositories\Admin\ProductRepository;
class ProductService
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function displayProductsOnTheTopPage()
    {
        $now_date = date('Y-m-d H:i:s');
        $query = Product::where('deleted_at', NULL)->where('is_display', 1)->where('is_reccomend', 1)->orderBy('updated_at', 'desc');
        $query->where(function($query) use ($now_date) {
            $query->where(function($query) {
                $query->where('public_start_date', NULL)->where('public_end_date', NULL);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date','<=', $now_date)->where('public_end_date', NULL);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date', NULL)->where('public_end_date', '>=', $now_date);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date', '<=', $now_date)->where('public_end_date', '>=', $now_date);
            });
        });
        return $this->productRepository->getByQuery($query);
    }
    public function searchProducts($id)
    {
        $now_date = date('Y-m-d H:i:s');
        $query = Product::where('category_id', $id)->where('deleted_at', NULL)->where('is_display', 1);
        $query->where(function($query) use ($now_date) {
            $query->where(function($query) {
                $query->where('public_start_date', NULL)->where('public_end_date', NULL);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date','<=', $now_date)->where('public_end_date', NULL);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date', NULL)->where('public_end_date', '>=', $now_date);
            })->Orwhere(function($query) use ($now_date) {
                $query->where('public_start_date', '<=', $now_date)->where('public_end_date', '>=', $now_date);
            });
        });

        return $this->productRepository->getByQuery($query);
    }
}