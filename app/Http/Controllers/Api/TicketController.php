<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $tickets = Ticket::with(['assignedTo', 'author', 'categories', 'status', 'responses.author'])
            // Users will want the last updated_at at the top, admins will want it the opposite.
            ->orderBy('updated_at', $request->user()->is_admin ? 'DESC' : 'ASC')
            ->get();

        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTicketRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketRequest $request)
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
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTicketRequest $request
     * @param \App\Models\Ticket                     $ticket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
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
    public function destroy(Ticket $ticket)
    {
        //
    }
}
