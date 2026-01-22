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
            'name' => 'required',
            'detail' => 'required|max:255',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'condition' => 'required|exists:conditions,id',
            'price' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',

            'detail.required' => '商品説明を入力してください',
            'detail.max' => '商品説明は255文字以内で入力してください',
            
            'categories.required' => '商品のカテゴリーを選択してください',
            'categories.*.exists' => '存在しないカテゴリーが選択されています',
            
            'condition.required' => '商品の状態を選択してください',
            'condition.*.exists' => '存在しない商品の状態が選択されています',
            
            'price.required' => '商品価格を入力してください',
            'price.integer' => '商品価格は数字で入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
            
            'image.required' => '商品画像を選択してください',
            'image.image' => '商品画像はimage形式のものを選択してください',
            'image.mimes' => '商品画像は拡張子が.jpegもしくは.png形式のものを選択してください',
            'image.max' => '商品画像は2MBまでのものを選択してください',
        ];
    }
}