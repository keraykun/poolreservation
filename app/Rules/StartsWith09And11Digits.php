<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StartsWith09And11Digits implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Use a regular expression to check if the value starts with "09" and has 11 digits
        if (!preg_match('/^09\d{9}$/', $value)) {
            $fail("The $attribute must start with '09' and contain 11 digits.");
        }
    }
}
