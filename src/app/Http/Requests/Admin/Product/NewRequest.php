<?php

namespace App\Http\Requests\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function attributes()
    {
        return [
            'model_number' => '型番',
            'part_number' => '品番',
            'name' => '商品名',
            'category_id' => 'カテゴリーID',
            'material_id' => '金種ID',
            'side_jewel_id' => '脇石ID',
            'side_jewel_ct' => '脇石カラット',
            'side_jewel_color_id' => '脇石カラー',
            'jewel_id' => '中石ID',
            'jewel_ct' => '中石カラット',
            'jewel_color_id' => '中石カラー',
            'text' => '備考',
            'image1' => '画像１',
            'image2' => '画像２',
            'image3' => '画像３',
            'image4' => '画像４',
            'image5' => '画像５',
            'is_display' => '表示／非表示',
            'is_reccomend' => 'オススメ',
            'public_start_date' => '掲載開始日',
            'public_end_date' => '掲載終了日',
            'status' => '状態',
            'donation_amount' => '寄付金額',
            'product_amount' => '商品金額',
            'cost' => 'コスト',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return [
            'model_number' => 'required|string',
            'part_number' => 'nullable|string',
            'name' => 'required|string',
            'category_id' => 'required|string',
            'material_id' => 'required|string',
            'side_jewel_id' => 'nullable|string',
            'side_jewel_ct' => 'nullable|string',
            'side_jewel_color_id' => 'nullable|string',
            'jewel_id' => 'nullable|string',
            'jewel_ct' => 'nullable|string',
            'jewel_color_id' => 'nullable|string',
            'text' => 'required|string',
            'image1' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image2' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image3' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image4' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image5' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'copy_image1' => 'nullable|string',
            'copy_image2' => 'nullable|string',
            'copy_image3' => 'nullable|string',
            'copy_image4' => 'nullable|string',
            'copy_image5' => 'nullable|string',
            'is_display' => 'required|in:0,1',
            'is_reccomend' => 'nullable|in:0,1',
            'public_start_date' => 'nullable|date',
            'public_end_date' => 'nullable|date|after:public_start_date',
            'status' => 'nullable|integer',
            'donation_amount' => 'nullable|string',
            'product_amount' => 'nullable|string',
            'cost' => 'nullable|string',
        ];
    }
}
