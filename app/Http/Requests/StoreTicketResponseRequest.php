<?php

namespace App\Http\Requests;

use App\Models\TicketResponse;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \App\Models\Ticket $ticket
 */
class StoreTicketResponseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', [TicketResponse::class, $this->ticket]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }
}
