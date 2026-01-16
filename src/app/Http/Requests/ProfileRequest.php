<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'img_path' => ['mimes:jpeg,png'],
            'name' => ['required', 'max:20'],
            'postal_code' => ['required', 'regex:/^[a-zA-Z0-9-]{8}$/'],
            'address' => ['required'],
        ];
    }

    public function messages() {
        return [
            'img_path.mimes' => '拡張子は.jpegもしくは.pngとしてください',
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => 'ハイフンありの8文字で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
