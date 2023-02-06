<?php

namespace App\Http\Requests;

use App\Helpers\LogActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreEmployeeRequest extends FormRequest
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
     * Get the validation rules that apply to the request.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required|exists:companies,id',
            'email' => 'email'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'El parametro :attribute es requerido',
            'last_name.required' => 'El parametro :attribute es requerido',
            'company_id.required' => "El parametro :attribute es requerido",
            'company_id.exists' => "El parametro :attribute no existe",
            'email.email' => 'El parametro :attribute no es un email',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        LogActivity::addToLog('Error validation employee','false','StoreEmployee','',json_encode($validator->errors(),true));

        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}
