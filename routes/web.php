<?php

use Illuminate\Support\Facades\Route;

Route::get('/participants', [ParticipantController::class, 'index']);
Route::post('/participants', [ParticipantController::class, 'store']);
Route::post('/participants/{id}/upgrade', [ParticipantController::class, 'upgrade']);
Route::post('/participants/{id}/bayar', [ParticipantController::class, 'bayar']);
