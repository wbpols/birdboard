<?php

namespace App\Http\Requests\Project;

use App\Models\Project\Project;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "title" => [
                "sometimes",
                "required",
            ],
            "description" => [
                "sometimes",
                "required",
            ],
            "notes" => [
                "nullable",
                "max:255",
            ],
        ];
    }

    /**
     * Get the Project model from the request.
     *
     * @return \App\Models\Project\Project
     */
    public function project(): Project
    {
        return is_object($this->route('project'))
            ? $this->route('project')
            : Project::findOrFail($this->route('project'));
    }

    /**
     * Save the updated data to the Project.
     *
     * @return \App\Models\Project\Project
     */
    public function save(): Project
    {
        return tap($this->project())->update($this->validated());
    }
}
