<?php

namespace App\Http\Requests\Auth;

use App\Enums\VerificationEnum;
use Illuminate\Foundation\Http\FormRequest;

class VerifyPasswordResetRequest extends FormRequest
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
            'password'  => ['required', 'string', 'confirmed'],
            'token'     =>  ['required', 'digits:6', 'exists:tokens,token']
        ];
    }
}
