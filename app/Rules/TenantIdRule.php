<?php

namespace App\Rules;

use App\Models\Tenant;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class TenantIdRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $slug_id = Str::slug($value);
        if(Tenant::where('id' , $slug_id)->exists()){
            $fail(':attribute is already exists');
        }
    }


}
