<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TicketStatus
 *
 * @property int $id
 * @property string $title
 * @property Ticket[] $tickets
 * @property-read int|null $tickets_count
 * @method static \Database\Factories\TicketStatusFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketStatus whereTitle($value)
 * @mixin \Eloquent
 */
class TicketStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The tickets of the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class, 'status_id');
    }
}
