<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('project.create');
        Route::put('/update/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::get('/edit/{project}', [ProjectController::class, 'edit'])->name('project.edit');
        Route::post('/store', [ProjectController::class, 'store'])->name('project.store');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('project.show');
        Route::delete('/destroy/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
    });

    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/', [TaskController::class, 'index'])->name('task.index');
        Route::get('/create', [TaskController::class, 'create'])->name('task.create');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('task.update');
        Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
        Route::post('/store', [TaskController::class, 'store'])->name('task.store');
        Route::get('/{task}', [TaskController::class, 'show'])->name('task.show');
        Route::delete('/destroy/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

