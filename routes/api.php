<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneratorController;

Route::post('/generar', [GeneratorController::class, 'generate']);