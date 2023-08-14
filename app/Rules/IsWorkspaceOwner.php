<?php

namespace App\Rules;

use App\Models\User;
use App\Models\Workspace;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsWorkspaceOwner implements ValidationRule
{
    public function __construct(public User $user)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $workspace = Workspace::where('id', $value)->where('owner_id', $this->user->id)->first();

        if (!$workspace) {
            $fail('You do not own this workspace.');
        }
    }
}
