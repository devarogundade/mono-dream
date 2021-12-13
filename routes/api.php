<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

# auth
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout']);

# tickets
Route::get('tickets', [TicketController::class, 'all']);
Route::get('users/{id}/tickets', [UserController::class, 'owned']);

Route::get('tickets/{id}', [TicketController::class, 'get']);
Route::get('tickets/user/create', [TicketController::class, 'create']);

Route::get('tickets/user/like', [TicketController::class, 'like']);

Route::get('categories', [CategoryController::class, 'all']);
Route::get('categories/{id}/tickets', [CategoryController::class, 'tickets']);

# review
Route::get('reviews/create/{id}', [ReviewController::class, 'create']);

# user
Route::get('users/{id}', [UserController::class, 'user']);

# transaction
Route::get('users/{id}/transactions', [TransactionController::class, 'history']);

# payment
Route::get('users/{id}/pay', [TicketController::class, 'onPurchase']);

