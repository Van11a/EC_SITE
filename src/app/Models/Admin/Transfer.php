<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Transfer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'management_number',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'tel',
        'postcode',
        'address1',
        'address2'
        'email',
        'status',
        'settlement_number',
        'payment_date',
        'settlement_token',
        'remarks',
    ];

    /**
     * 決済情報に関連している商品の取得
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}