<?php

namespace App\Http\Requests;

use App\Helpers\LogActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'email',
            'logo' => ''
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
            'name.required' => 'El parametro :attribute es requerido',
            'email.email' => 'El parametro :attribute no es un email',
            'logo.dimensions' => 'El logo debe tener un minimo de 100px * 100px',
            'logo.mimes' => 'El parametro :attribute debe de     ser de tipo jpeg, png o jpg',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        LogActivity::addToLog('Error validation company','false','UpdateCompany','',json_encode($validator->errors(),true));

        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}
