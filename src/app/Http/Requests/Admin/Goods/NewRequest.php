<?php

namespace App\Http\Requests\Admin\Goods;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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
            'part_number' => '品番',
            'name' => '商品名',
            'parent_category_id' => '親カテゴリーID',
            'sub_category_id' => 'サブカテゴリーID',
            'text' => '備考',
            'image1' => '画像１',
            'image2' => '画像２',
            'image3' => '画像３',
            'image4' => '画像４',
            'image5' => '画像５',
            'before_image1' => '更新前画像1',
            'before_image2' => '更新前画像2',
            'before_image3' => '更新前画像3',
            'before_image4' => '更新前画像4',
            'before_image5' => '更新前画像5',
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
            'image1' => 'required_without:before_image1|nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image2' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image3' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image4' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'image5' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'before_image1' => 'nullable|string',
            'before_image2' => 'nullable|string',
            'before_image3' => 'nullable|string',
            'before_image4' => 'nullable|string',
            'before_image5' => 'nullable|string',
            'is_display' => 'required|in:0,1',
            'is_reccomend' => 'nullable|in:0,1',
            'public_start_date' => 'nullable|date',
            'public_end_date' => 'nullable|date|after:public_start_date',
            'stock' => 'nullable|integer',
            'amount' => 'required|string',
            'cost' => 'nullable|string',
        ];
    }

    /**
     * バリデーション前に画像1〜5を先にアップロード
     */
    protected function prepareForValidation()
    {
        $service = app(\App\Services\Admin\GoodsService::class);
        $results = $service->uploadImageToTemporaryServer($this->all(), $this);

        $mergeData = [];
        for ($i = 1; $i <= 5; $i++) {
            $key = 'image' . $i;

            // サービスから返ってきたパスがあれば、before_imageX としてマージ
            if (isset($results[$key])) {
                $mergeData['before_image' . $i] = $results[$key];
            }
        }

        if (!empty($mergeData)) {
            $this->merge($mergeData);
        }
    }

    /**
     * バリデーション失敗時の処理
     * 選択した画像プレビューが消えるのを解消するためのもの
     */
    protected function failedValidation(Validator $validator)
    {
        $inputs = $this->all();
        for ($i = 1; $i <= 5; $i++) {
            unset($inputs['image' . $i]); //ファイル（画像）を抹消
        }

        $response = redirect()
            ->to($this->getRedirectUrl())
            ->withInput($inputs) // before_imageを保持
            ->withErrors($validator, $this->errorBag); // エラーメッセージを保持

        // 例外オブジェクトを作成し、作成したレスポンスをセットして投げる
        $exception = new ValidationException($validator);
        $exception->response = $response;

        throw $exception;
    }

    /**
     * 画像のバリデーションメッセージ
     */
    public function messages()
    {
        return [
            'image1.required' => ':attributeは必須です。',
            'image1.required_without' => ':attributeは必須です。',
        ];
    }
}
