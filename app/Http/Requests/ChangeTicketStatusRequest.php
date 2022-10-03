<?php

namespace App\Http\Requests;

use App\Models\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read \App\Models\Ticket $ticket
 * @method \App\Models\User user($guard = null)
 */
class ChangeTicketStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('updateStatus', [$this->ticket]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status_id' => [
                'required',
                'integer',
                Rule::exists(TicketStatus::class, 'id'),
            ],
        ];
    }
}
