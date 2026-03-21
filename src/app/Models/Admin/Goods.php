<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'part_number',
        'name',
        'category_id',
        'text',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'is_display',
        'public_start_date',
        'public_end_date',
        'stock',
        'is_reccomend',
        'amount',
        'cost'
    ];

    /**
     * 商品に関連しているカテゴリーの取得
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
