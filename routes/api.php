<?php

use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TimetableLessonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\UpdateController;
use App\Http\Controllers\User\DeleteController;
use App\Http\Controllers\User\ShowController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BellController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PeriodTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubgroupController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\YearController;
use App\Http\Middleware\PermissionMiddleware;
use App\Models\Year;

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function(){
    Route::post('/', StoreController::class);
    Route::get('/', IndexController::class);
    Route::patch('/{user}', UpdateController::class);
    Route::delete('/', DeleteController::class);
    Route::get('/{user}', ShowController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::get('roles', [RoleController::class, 'index']);

Route::resource('bell', BellController::class)->middleware('permission:view_bell' );
Route::resource('year', YearController::class);
Route::resource('period', PeriodController::class);


Route::resource('subject', SubjectController::class);

Route::resource('group', GroupController::class)->middleware('auth:sanctum' );

Route::resource('period_type', PeriodTypeController::class);

Route::resource('subgroup', SubgroupController::class);

Route::resource('load', LoadController::class);

Route::resource('timetable', TimetableController::class);

Route::resource('timetable_lesson', TimetableLessonController::class);

Route::get('period_types_by_group/{group}', [PeriodTypeController::class, 'getPeriodTypesByGroup']);

Route::get('groups/loads/{group}', [GroupController::class, 'getGroupLoads'])->middleware('auth:sanctum');

Route::group(['prefix' => 'lessons', 'middleware' => 'auth:sanctum'], function(){
   Route::get('/{group}/{load}/{period}', [LessonController::class, 'index']);
});

Route::group(['prefix' => 'students', 'middleware' => 'auth:sanctum'], function(){
    Route::get('/{group}', [StudentController::class, 'index']);
});
