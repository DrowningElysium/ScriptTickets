<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignTicketRequest;
use App\Http\Requests\ChangeTicketStatusRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\TicketStatus;

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
        // Don't want to assume it always has ID 1, the type DocBlock is so my IDE doesn't throw null pointer warnings.
        /** @var TicketStatus $defaultStatus */
        $defaultStatus = TicketStatus::where('title', 'New')->first();

        $ticket = $request->user()->ownedTickets()->create([
            'status_id' => $defaultStatus->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $ticket->categories()->attach($request->input('categories'));

        $ticket->load(['assignedTo', 'author', 'categories', 'responses.author', 'status']);

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
        $ticket->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $ticket->categories()->sync($request->input('categories'));

        $ticket->load(['assignedTo', 'author', 'categories', 'responses.author', 'status']);

        return response()->json($ticket);
    }

    /**
     * Assign resource to user.
     *
     * @param \App\Http\Requests\AssignTicketRequest $request
     * @param \App\Models\Ticket                     $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function assign(AssignTicketRequest $request, Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        $ticket->update([
            'assigned_to_id' => $request->input('user_id'),
        ]);

        $ticket->load(['assignedTo', 'author', 'categories', 'responses.author', 'status']);

        return response()->json($ticket);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ChangeTicketStatusRequest $request
     * @param \App\Models\Ticket                           $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(ChangeTicketStatusRequest $request, Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        $ticket->update([
            'status_id' => $request->input('status_id'),
        ]);

        $ticket->load(['assignedTo', 'author', 'categories', 'responses.author', 'status']);

        return response()->json($ticket);
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
