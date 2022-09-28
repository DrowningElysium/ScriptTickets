<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketResponsePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, Ticket $ticket): \Illuminate\Auth\Access\Response|bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Ticket         $ticket
     * @param \App\Models\TicketResponse $ticketResponse
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TicketResponse $ticketResponse, Ticket $ticket): \Illuminate\Auth\Access\Response|bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Ticket $ticket
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Ticket $ticket): \Illuminate\Auth\Access\Response|bool
    {
        return $user->is_admin || $ticket->author_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Ticket         $ticket
     * @param \App\Models\TicketResponse $ticketResponse
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TicketResponse $ticketResponse, Ticket $ticket): \Illuminate\Auth\Access\Response|bool
    {
        // TODO: Should an admin be able to edit a users response?
        return $ticketResponse->author_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Ticket         $ticket
     * @param \App\Models\TicketResponse $ticketResponse
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TicketResponse $ticketResponse, Ticket $ticket): \Illuminate\Auth\Access\Response|bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Ticket         $ticket
     * @param \App\Models\TicketResponse $ticketResponse
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TicketResponse $ticketResponse, Ticket $ticket): \Illuminate\Auth\Access\Response|bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Ticket         $ticket
     * @param \App\Models\TicketResponse $ticketResponse
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TicketResponse $ticketResponse, Ticket $ticket): \Illuminate\Auth\Access\Response|bool
    {
        //
    }
}
