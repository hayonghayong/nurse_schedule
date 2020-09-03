<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TreatmentPageApiRequest extends FormRequest
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
          'name' => 'required|max:255',
          'time_required' => 'required|min:1|max:3',
          'required_flg' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response['status']  = 400;
        $response['statusText'] = 'バリデーションエラーやな.';
        $response['errors']  = $validator->errors();
        throw new HttpResponseException(
            response()->json( $response, 200 )
        );
    }
}
