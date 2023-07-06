<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Tenant;

class UniqueTenantmobileRule implements ValidationRule
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
            if ($tenant->mobile == $value){
                $fail('هذا الرقم مستخدم من قبل');
            }
        }
    }
}
