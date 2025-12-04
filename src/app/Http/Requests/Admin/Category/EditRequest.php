<?php
namespace App\Http\Requests\Admin\Category;
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
            'name'  => 'カテゴリー名',
            'display_order'=> '表示順',
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
            'display_order' => [
                'nullable',
                'integer',
                // 'required',
                // 'integer',
                // Rule::unique('categories')->where(function ($request){
                //     return $request->whereNull('deleted_at');
                // })
            ],
        ];
    }
}