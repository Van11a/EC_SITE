<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'  => '利用者名',
            'login_id'   => 'ログインID',
            'password' => 'パスワード',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user_model = $this->route('user');

        return [
            'name' => 'required|string|max:30',
            'login_id' => [
                'required',
                'string',
                Rule::unique('users')->ignore($user_model)
            ],
            'password' => [
                'nullable',
                'min:6',
                'confirmed',
                'regex:/^[a-zA-Z0-9_-]+$/',
            ],
            'password_confirmation' => 'nullable',
        ];
    }
}
