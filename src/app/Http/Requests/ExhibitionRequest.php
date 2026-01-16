<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required', 'max:255'],
            'img_path' => ['required', 'mimes:jpeg,png'],
            'category_id' => ['required'],
            'condition' => ['required'],
            'price' => ['required', 'integer', 'gt:0'],
        ];
    }

    public function messages() {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',
            'img_path.required' => '商品画像をアップロードしてください',
            'img_path.mimes' => '拡張子は.jpegもしくは.pngとしてください',
            'category_id.required' => '商品のカテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品の価格を入力してください',
            'price.integer' => '半角数字で入力してください',
            'price.gt' => '0円以上を設定してください',
        ];
    }
}
