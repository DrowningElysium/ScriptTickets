<?php

namespace App\Http\Requests;

use App\Models\TicketCategory;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \App\Models\TicketResponse $ticketCategory
 */
class StoreTicketCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', TicketCategory::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'unique:'.TicketCategory::class],
        ];
    }
}
