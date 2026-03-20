<?php

namespace App\Http\Requests\Admin\KeyVisual;

use Illuminate\Validation\Rule;
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
            'title'  => 'タイトル',
            'image' => '画像',
            'url'  => 'URL',
            'is_new_window'  => '新規ウインドウ',
            'public_start_date' => '掲載開始日',
            'public_end_date' => '掲載終了日',
            'display_order' => '表示順',
            'is_display' => '表示／非表示',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function  rules()
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'required_without:before_image|nullable|image|mimes:jpeg,png,jpg,pdf',
            'before_image' => 'nullable|string',
            'url' => 'nullable|url',
            'is_new_window' => 'nullable|in:0,1',
            'public_start_date' => 'nullable|date',
            'public_end_date' => 'nullable|date|after:public_start_date',
            'display_order' => [
                'required',
                'integer',
                Rule::unique('key_visuals')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ],
            'is_display' => 'required|in:0,1',
        ];
    }

    /**
     * バリデーション前に画像のみ先にアップロード
     */
    protected function prepareForValidation()
    {
        if ($this->hasFile('image')) {
            $key_visual = app(\App\Services\Admin\KeyVisualService::class)
                ->uploadImageToTemporaryServer($this->all(), $this);

            if (isset($key_visual['image'])) {
                $this->merge(['before_image' => $key_visual['image']]);
            }
        }
    }

    /**
     * バリデーション失敗時の処理
     */
    protected function failedValidation(Validator $validator)
    {
        $inputs = $this->all();
        unset($inputs['image']);

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
            'image.required' => ':attributeは必須です。',
            'image.required_without' => ':attributeは必須です。',
        ];
    }
}
