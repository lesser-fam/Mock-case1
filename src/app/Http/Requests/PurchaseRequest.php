<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => 'required|in:convenience,card',
            'post_num' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
            'building' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            
            'post_num.required' => '郵便番号を入力してください',
            'post_num.regex' => '郵便番号はハイフンありの8文字で入力してください',
            
            'address.required' => '住所を入力してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $item = \App\Models\Item::findOrFail(
                $this->route('item_id')
            );
            
            if (
                $this->payment_method === 'convenience' &&
                $item->price < 120
            ) {
                $validator->errors()->add(
                    'payment_method',
                    '120円未満の商品はコンビニ支払いを利用できません'
                );
            }
        });
    }
}
