<?php

namespace App\Rules;

use App\Support\YouTube;
use Illuminate\Contracts\Validation\Rule;

class ValidYouTubeUrl implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (! filled($value)) {
            return true;
        }

        return YouTube::extractVideoId((string) $value) !== null;
    }

    public function message(): string
    {
        return 'يجب أن يكون :attribute رابط يوتيوب صحيحًا.';
    }
}
