<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PatientPageApiRequest extends FormRequest
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
        return 
        [ 
          'room'=>'required|max:10',
          'name' => 'required|max:255',
          'sex' => 'required|min:1|max:1',
          'birthday' => 'required',
        //   'hospitalization_date' => 'required',
        //   'surgery_date' => 'required',
          'memo' => 'max:30',
        ];
    }

    // 200で返してしまうとaxios成功したとみなされるので下記方法で表に表示されるメッセージを指定できます！
    protected function failedValidation(Validator $validator) {
        $response['status']  = 400;
        $response['statusText'] = 'バリデーションエラーやな.';
        $response['errors']  = $validator->errors();
        throw new HttpResponseException(
            response()->json( $response, 200 )
        );
    }

    //　表に表示されるバリデーションメッセージを attributesとmessages で指定できます。
    public function attributes()
    {
    return [
        'room' => '部屋番号',
        'name' => '患者名',
        'sex' => '性別',
        'birthday' => '誕生日',
        'hospitalization_date' => '入院日',
        'surgery_date' => '手術日',
        'memo' => '特記事項',
        ];
    }

    //　こんな感じでバリデーションメッセージを指定できます。（※　例なので不足してるものがあります）
    public function messages() {
        return [
            'room.required' => ':attributeは入力必須です。',
            'room.max'      => ':attributeは10文字以下で入力してください。',
            'name.required' => ':attributeは入力必須です。',
            'name.max'      => ':attributeは25文字以下で入力してください。',
            'memo.max'      => ':attributeは30文字以下で入力してください。',

        ];
    }
}
