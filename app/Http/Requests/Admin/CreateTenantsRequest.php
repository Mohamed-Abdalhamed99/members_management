<?php

namespace App\Http\Requests\Admin;

use App\Rules\TenantIdRule;
use App\Rules\UniqueTenantEmailRule;
use App\Rules\UniqueTenantmobileRule;
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
            'domain' => ['required' , 'string' , 'max:255' , 'unique:tenants,id'],
            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'email' => ['required' , 'email' ,  new UniqueTenantEmailRule()],
            'mobile' => ['required' , 'string' ,  new UniqueTenantmobileRule()],
        ];
    }
}
