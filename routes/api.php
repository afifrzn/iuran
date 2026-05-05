<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantController;

Route::get('/participants', [ParticipantController::class, 'index']);
Route::post('/participants', [ParticipantController::class, 'store']);
Route::post('/participants/{id}/upgrade', [ParticipantController::class, 'upgrade']);
Route::post('/participants/{id}/bayar', [ParticipantController::class, 'bayar']);
Route::post('/participants/{id}/batal', [ParticipantController::class, 'batal']);
Route::post('/participants/{id}/downgrade', [ParticipantController::class, 'downgrade']);