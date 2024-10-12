<?php

use App\Http\Controllers\Client\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::any('{any}', [IndexController::class, '__invoke'])
    ->where('any', '.*');
