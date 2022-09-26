<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TicketResponse
 *
 * @property int $id
 * @property int $author_id
 * @property int $ticket_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\User $author
 * @property \App\Models\Ticket $ticket
 * @method static \Database\Factories\TicketResponseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketResponse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_id',
        'ticket_id',
        'content',
    ];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = [];

    /**
     * The author of the ticket response.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * The ticket of the ticket response.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
