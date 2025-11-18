<?php

namespace App\Http\Requests\Admin\KeyVisual;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'title'  => 'タイトル',
            'image' => '画像',
            'before_image' => '更新前画像',
            'url'  => 'URL',
            'is_new_window'  => '新規ウインドウ',
            'public_start_date' => '掲載開始日',
            'public_end_date' => '掲載終了日',
            'display_order'=> '表示順',
            'is_display' => '表示／非表示',
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
            'title' => 'required|string',
            'image' => 'nullable|max:2000|image|mimes:jpeg,png,jpg,pdf',
            'before_image' => 'required|string',
            'url' => 'nullable|url',
            'is_new_window' => 'nullable|in:0,1',
            'public_start_date' => 'nullable|date',
            'public_end_date' => 'nullable|date|after:public_start_date',
            'display_order' => [
                'required',
                'integer',
                Rule::unique('key_visuals')->ignore($request->id,'id')->where(function ($request){
                    return $request->whereNull('deleted_at');
                })
            ],
            'is_display' => 'required|in:0,1',
        ];
    }
}
