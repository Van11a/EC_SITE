<?php
namespace App\Http\Requests\Admin\User;
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
    public function rules(Request $request)
    {
        return [
            'name'=>'required|string|max:30',
            'login_id'=>[
                'required', 
                'string', 
                Rule::unique('users')->ignore($request->id,'id')],
            'password'=>[
                'required',
                'min:6',
                'confirmed',
                'regex:/^[a-zA-Z0-9_-]+$/',
            ],
        ];
    }
}