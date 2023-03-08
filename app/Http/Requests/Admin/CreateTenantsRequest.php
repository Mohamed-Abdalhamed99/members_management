<?php

namespace App\Http\Requests\Admin;

use App\Rules\TenantIdRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTenantsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'domain' => ['required' , 'string' , 'max:255' , 'unique:domains,domain'],
            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'email' => ['required' , 'email'],
            'password' => ['required' , 'string' , 'confirmed'],
            'telephone' => ['nullable' , 'string' , 'unique:users,telephone'],
            'address' => ['nullable' , 'string'],
            'avatar' => ['nullable' , 'image'],
            'plan_id' => ['required' , 'exists:plans,id'],

            // company attributes
            'company_name' => ['required' , 'string' , 'max:255' , new TenantIdRule()],
            'company_email' => ['nullable' , 'email'],
            'company_phone' => ['nullable' , 'string'],
            'company_fax' => ['nullable' , 'string'],
            'company_website' => ['nullable' , 'string' ,'max:255'],
            'company_bank' => ['nullable' , 'string'],
            'company_bank_account' => ['nullable' , 'string'],
            'company_notes' => ['nullable' , 'string'],
            'company_fiscal_code' => ['nullable' , 'string'],
            'company_logo' => ['nullable' , 'image'],
        ];
    }
}
