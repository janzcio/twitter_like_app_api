<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreUpdateTweetRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required',
            'attachment' => 'required|image|max:2048',
        ];
    }
}
