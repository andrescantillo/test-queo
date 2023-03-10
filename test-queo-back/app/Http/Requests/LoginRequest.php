<?php

namespace App\Http\Requests;

use App\Helpers\LogActivity;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'email|required',
            'password' => 'required'
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
            'email.email' => 'El parametro :attribute debe ser tipo correo',
            'email.required' => 'El parametro :attribute es requerido',
            "password.required" => "El parametro :attribute es requerido"
        ];
    }

    public function failedValidation(Validator $validator)
    {

        LogActivity::addToLog('The given data was invalid','false','LoginQueoApi',json_encode(request()->all()),json_encode($validator->errors()));

        throw new HttpResponseException(response()->json(
        [
            'status'   => "Error",
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}
