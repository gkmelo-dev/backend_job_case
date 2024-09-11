<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
// use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return response()->json(['ok' => 'true']);
});

Route::prefix('clients')->group(function () {
    Route::post('/', [ClientController::class, 'store']); // Create a new client
    Route::get('/', [ClientController::class, 'index']); // List all clients
    Route::get('/{id}', [ClientController::class, 'show']); // Show a specific client
    Route::put('/{id}', [ClientController::class, 'update']); // Update a client
    Route::delete('/{id}', [ClientController::class, 'destroy']); // Delete a client
});

// Route::prefix('projects')->group(function () {
//     Route::post('/', [ProjectController::class, 'store']); // Create a new project
//     Route::get('/', [ProjectController::class, 'index']); // List all projects
//     Route::get('/{id}', [ProjectController::class, 'show']); // Show a specific project
//     Route::put('/{id}', [ProjectController::class, 'update']); // Update a project
//     Route::delete('/{id}', [ProjectController::class, 'destroy']); // Delete a project
// });
