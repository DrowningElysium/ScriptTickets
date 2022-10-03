<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketStatusRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Models\TicketStatus;

class TicketStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $statuses = TicketStatus::get();

        return response()->json($statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTicketStatusRequest $request
     * @param \App\Models\TicketStatus                     $ticketStatus
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketStatusRequest $request, TicketStatus $ticketStatus): \Illuminate\Http\JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TicketStatus $ticketStatus
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TicketStatus $ticketStatus): \Illuminate\Http\JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTicketStatusRequest $request
     * @param \App\Models\TicketStatus                     $ticketStatus
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        UpdateTicketStatusRequest $request,
        TicketStatus $ticketStatus
    ): \Illuminate\Http\JsonResponse {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TicketStatus $ticketStatus
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TicketStatus $ticketStatus): \Illuminate\Http\JsonResponse
    {
        //
    }
}
