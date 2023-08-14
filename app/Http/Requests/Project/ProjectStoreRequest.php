<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use App\Rules\IsWorkspaceOwner;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Project::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'between:1,100'],
            'color' => ['required', 'string', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
            'workspace_id' => ['required', new IsWorkspaceOwner($this->user())],
        ];
    }
}
