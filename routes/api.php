<?php

use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\TicketCategoryController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketResponseController;
use App\Http\Controllers\Api\TicketStatusController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->group(static function () {
    Route::get('user', [AuthenticatedSessionController::class, 'currentUser']);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

    // Tickets
    Route::apiResource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/assign', [TicketController::class, 'assign']);
    Route::post('tickets/{ticket}/status', [TicketController::class, 'changeStatus']);

    // Ticket Categories
    Route::apiResource('ticket-categories', TicketCategoryController::class)
        ->except(['show']);

    // Ticket statuses
    Route::get('ticket-statuses', [TicketStatusController::class, 'index']);

    // Ticket Responses
    Route::post('tickets/{ticket}/responses', [TicketResponseController::class, 'store']);
    Route::put('tickets/{ticket}/responses/{ticketResponse}', [TicketResponseController::class, 'update'])
        ->scopeBindings();

    // Users
    Route::get('users', [UserController::class, 'index']);
});
