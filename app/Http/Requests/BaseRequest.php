<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class BaseRequest extends FormRequest
{
    protected $model;

    protected $errors = [];

    public $data = [];

    /**
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        foreach( $validator->errors()->get('*') as $key => $fieldError) {
            foreach( $fieldError AS $error) {
                $field = explode('.', $key);
                $data = [
                    'field' => $field[0],
                    'message' => $error
                ];

                if(count($field) > 1) {
                    $data['language'] = $field['1'];
                }

                $this->errors[] = $data;
            }
        }

        throw new HttpResponseException(
            response()->json([
                'status' => 'Error',
                'description' => 'Unprocessable entry',
                'errors' => $this->errors,
            ], 422)
        );
    }
}
