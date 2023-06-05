<?php

namespace App\Rules;

use App\Models\Tenant;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueTenantEmailRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tenants = Tenant::get();

        foreach ($tenants as $tenant){
            if ($tenant->email == $value){
                $fail('البريد الالكتروني مستخدم من قبل');
            }
        }
    }
}
