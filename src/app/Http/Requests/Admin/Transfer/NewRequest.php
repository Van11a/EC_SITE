<?php

namespace App\Http\Requests\Admin\Transfer;
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
            'last_name' => '姓',
            'first_name' => '名',
            'last_name_kana' => '姓（かな）',
            'first_name_kana' => '名（めい）',
            'tel' => '電話番号',
            'postcode' => '郵便番号',
            'email' => 'メール',
            'settlement_amount' => '決済金額',
            'settlement_number' => '決済番号',
            'remarks' => '備考',
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
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'last_name_kana' => [
                'required',
                'string',
                'regex:/^[ぁ-ゞ]+$/u',
            ],
            'first_name_kana' => [
                'required',
                'string',
                'regex:/^[ぁ-ゞ]+$/u',
            ],
            'tel' => [
                'required',
                'string',
                'regex:/\A0\d{9,10}\z/',
            ],
            'postcode' => [
                'required',
                'string',
                'regex:/\A\d{7}\z/',
            ],
            'email' => 'required|email:filter,dns',
            'settlement_amount' => 'required|integer|min:1',
            'settlement_number' => 'nullable|string',
            'remarks' => 'nullable|string',
        ];
    }
}
