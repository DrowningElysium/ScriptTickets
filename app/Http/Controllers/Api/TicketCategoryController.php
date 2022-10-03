<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteTicketCategoryRequest;
use App\Http\Requests\StoreTicketCategoryRequest;
use App\Http\Requests\UpdateTicketCategoryRequest;
use App\Models\TicketCategory;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = TicketCategory::withCount(['tickets'])->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTicketCategoryRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $ticketCategory = TicketCategory::create($request->validated());
        $ticketCategory->loadCount(['tickets']);

        return response()->json($ticketCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TicketCategory $ticketCategory
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TicketCategory $ticketCategory): \Illuminate\Http\JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTicketCategoryRequest $request
     * @param \App\Models\TicketCategory                     $ticketCategory
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        UpdateTicketCategoryRequest $request,
        TicketCategory $ticketCategory,
    ): \Illuminate\Http\JsonResponse {
        $ticketCategory->update($request->validated());
        $ticketCategory->loadCount(['tickets']);

        return response()->json($ticketCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\DeleteTicketCategoryRequest $request
     * @param \App\Models\TicketCategory                     $ticketCategory
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteTicketCategoryRequest $request, TicketCategory $ticketCategory): \Illuminate\Http\JsonResponse
    {
        $ticketCategory->delete();

        return response()->json();
    }
}
