<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $tickets = Ticket::with(['assignedTo', 'author', 'categories', 'status'])->get();

        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTicketRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketRequest $request): \Illuminate\Http\JsonResponse
    {
        //
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
        $ticket->load(['assignedTo', 'author', 'categories', 'responses.author', 'status']);

        return response()->json($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTicketRequest $request
     * @param \App\Models\Ticket                     $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        //
    }
}
