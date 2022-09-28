<?php

use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\TicketCategoryController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('reset-password', [NewPasswordController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::apiResource('tickets', TicketController::class);

    // Ticket Categories
    Route::apiResource('ticket-categories', TicketCategoryController::class)
        ->except(['show']);

    // Ticket Responses
    Route::post('tickets/{ticket}/responses', [TicketResponseController::class, 'store']);
    Route::put('tickets/{ticket}/responses/{ticketResponse}', [TicketResponseController::class, 'update'])
        ->scopeBindings();
});

Route::middleware('auth:sanctum')->get('/user', static function (Request $request) {
    return $request->user();
});
