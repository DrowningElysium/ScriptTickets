<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Laravel is weird, so for some reason the variable uses snake case here instead of camel case.
 * @property-read \App\Models\TicketCategory $ticket_category
 * @method \App\Models\User user($guard = null)
 */
class DeleteTicketCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->ticket_category);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $validator = $this->getValidatorInstance();
        $validator->after(function (Validator $validator) {
            if ($this->ticket_category->tickets()->count()) {
                $validator->errors()->add('tickets', 'The ticket category has associated tickets.');
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
