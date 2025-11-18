<?php
namespace App\Repositories\Front;
use App\Models\Admin\Product;
class TransferRepository
{
    protected $product;
    public function __construct(Product $product)
    {
        return $this->product = $product;
    }
    public function getByQuery($query)
    {
        return $query->orderBy('product_amount', 'asc')->paginate(6);
    }
}