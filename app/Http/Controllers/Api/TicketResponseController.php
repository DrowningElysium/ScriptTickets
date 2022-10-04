<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketResponseRequest;
use App\Http\Requests\UpdateTicketResponseRequest;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Notifications\NewTicketResponseNotification;

class TicketResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTicketResponseRequest $request
     * @param \App\Models\Ticket                            $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketResponseRequest $request, Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        $response = $ticket->responses()
            ->create([
                'author_id' => $request->user()->id,
                'content' => $request->input('content'),
            ]);

        // Touch the ticket, so it has a new timestamp
        $ticket->touch();
        $ticket->load(['assignedTo', 'author', 'categories', 'responses.author', 'status']);

        // Let the original author know.
        $ticket->author->notify(new NewTicketResponseNotification($ticket, $response));

        return response()->json($ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTicketResponseRequest $request
     * @param \App\Models\Ticket                             $ticket
     * @param \App\Models\TicketResponse                     $ticketResponse
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        UpdateTicketResponseRequest $request,
        Ticket $ticket,
        TicketResponse $ticketResponse
    ): \Illuminate\Http\JsonResponse {
        $ticketResponse->update([
            'content' => $request->input('content'),
        ]);

        $ticket->load(['assignedTo', 'author', 'categories', 'responses.author', 'status']);

        return response()->json($ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Ticket         $ticket
     * @param \App\Models\TicketResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ticket $ticket, TicketResponse $response): \Illuminate\Http\JsonResponse
    {
        //
    }
}
