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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image_path' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['exists:categories,id'],
            'condition' => ['required'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',
            'image_path.required' => '商品画像をアップロードしてください',
            'image_path.image' => '商品画像は画像ファイルを選択してください',
            'image_path.mimes' => '商品画像は.jpegまたは.png形式でアップロードしてください',
            'image_path.max' => '商品画像は2MB以内でアップロードしてください',
            'category_ids.required' => '商品のカテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '商品価格は数値で入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
            'price.max' => '商品価格は99999999円以下で入力してください',
        ];
    }
}
