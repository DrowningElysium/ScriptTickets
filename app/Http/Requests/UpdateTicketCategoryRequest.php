<?php

namespace App\Http\Requests;

use App\Models\TicketCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Laravel is weird, so for some reason the variable uses snake case here instead of camel case.
 * @property \App\Models\TicketCategory $ticket_category
 * @method \App\Models\User user($guard = null)
 */
class UpdateTicketCategoryRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                Rule::unique(TicketCategory::class, 'title')
                    ->ignoreModel($this->ticket_category),
            ],
        ];
    }
}
