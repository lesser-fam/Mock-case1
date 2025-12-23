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
            'user_name' => 'required|max:20',
            'post_num' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
            'building' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => 'ユーザー名を入力してください',
            'user_name.max' => 'ユーザー名は20文字以内で入力してください',
            'post_num.required' => '郵便番号を入力してください',
            'post_num.regex' => '郵便番号はハイフンありの8文字で入力してください',
            'address.required' => '住所を入力してください',
            'image.image' => 'プロフィール画像はimage形式のものを選択してください',
            'image.mimes' => 'プロフィール画像は拡張子が.jpegもしくは.png形式のものを選択してください',
        ];
    }
}
