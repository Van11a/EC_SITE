<?php
namespace App\Http\Requests\Admin\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'parent_id'=> '親カテゴリーID',
        ];
    }

    //渡ってきた値の型をintに変換
    protected function prepareForValidation()
    {
        $data = $this->all();
        if (isset($data['parent_id']) && is_numeric($data['parent_id'])) {
            $data['parent_id'] = (int) $data['parent_id'];
        }

        if (isset($data['sub_categories']) && is_array($data['sub_categories'])) {
            
            $sub_categories = [];
            foreach ($data['sub_categories'] as $index => $sub_category) {
                if (isset($sub_category['id']) && is_numeric($sub_category['id'])) {
                    $sub_category['id'] = (int) $sub_category['id'];
                } else {
                    $sub_category['id'] = null; 
                }
                unset($sub_category['parent_id']);

                $subCategories[$index] = $sub_category;
            }
            $data['sub_categories'] = $subCategories;
        }

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        $url_parent_id = $this->route('category')->id ?? null;

        return [
            'sub_categories' => [
                'required',
                'array',
            ],
            'parent_id' => [
                'required',
                'integer',
                Rule::in([$url_parent_id]),
            ],
            'sub_categories.*.id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],
            'sub_categories.*.name' => [
                'nullable',
                'string',
                'max:30',
            ],
            'sub_categories.*.display_order' => [
                'nullable',
                'integer',
            ],
        ];
    }
}