<?php

namespace App\Http\Requests\Admin\Goods;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function attributes()
    {
        return [
            'part_number' => '品番',
            'name' => '商品名',
            'parent_category_id' => '親カテゴリーID',
            'sub_category_id' => '子カテゴリーID',
            'text' => '備考',
            'image1' => '画像１',
            'image2' => '画像２',
            'image3' => '画像３',
            'image4' => '画像４',
            'image5' => '画像５',
            'before_image1' => '更新前の画像１',
            'before_image2' => '更新前の画像２',
            'before_image3' => '更新前の画像３',
            'before_image4' => '更新前の画像４',
            'before_image5' => '更新前の画像５',
            'is_deleted_image2' => '画像２削除フラグ',
            'is_deleted_image3' => '画像３削除フラグ',
            'is_deleted_image4' => '画像４削除フラグ',
            'is_deleted_image5' => '画像５削除フラグ',
            'is_display' => '表示／非表示',
            'is_reccomend' => 'オススメ',
            'public_start_date' => '掲載開始日',
            'public_end_date' => '掲載終了日',
            'stock' => '在庫数',
            'amount' => '商品金額',
            'cost' => 'コスト',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'part_number' => 'required|string',
            'name' => 'required|string',
            'parent_category_id' => 'required|string',
            'sub_category_id' => 'nullable|string',
            'text' => 'required|string',
            'image1' => 'required|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image2' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image3' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image4' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image5' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'before_image1' => 'nullable|string',
            'before_image2' => 'nullable|string',
            'before_image3' => 'nullable|string',
            'before_image4' => 'nullable|string',
            'before_image5' => 'nullable|string',
            'is_deleted_image2' => 'nullable|string',
            'is_deleted_image3' => 'nullable|string',
            'is_deleted_image4' => 'nullable|string',
            'is_deleted_image5' => 'nullable|string',
            'is_display' => 'required|in:0,1',
            'is_reccomend' => 'nullable|in:0,1',
            'public_start_date' => 'nullable|date',
            'public_end_date' => 'nullable|date|after:public_start_date',
            'stock' => 'nullable|integer',
            'amount' => 'required|string',
            'cost' => 'nullable|string',
        ];
    }
}
