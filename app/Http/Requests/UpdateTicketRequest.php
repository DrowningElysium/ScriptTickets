<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read \App\Models\Ticket $ticket
 * @method \App\Models\User user($guard = null)
 */
class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', [$this->ticket]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:1'],
            'content' => ['required', 'string', 'min:1'],
            'categories' => ['array', 'min:1'],
            'categories.*' => ['integer', Rule::exists('ticket_categories', 'id')],
        ];
    }
}
