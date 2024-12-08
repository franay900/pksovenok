<?php

use App\Http\Controllers\Client\IndexController;
use Illuminate\Support\Facades\Route;



require __DIR__.'/auth.php';

Route::any('{any}', [IndexController::class, '__invoke'])
    ->where('any', '.*');
