<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// dd(LaravelLocalization::setLocale());
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::get('/', [HomeController::class, 'index'])->name('home');

            Route::get('/category/{slug}', [TaskController::class, 'lists'])->name('tasks.list');
            Route::get('/category/{slug}/task/create', [TaskController::class, 'create'])->name('task.create');

            Route::get('/task/{slug}', [TaskController::class, 'edit'])->name('task.edit');
            Route::put('/task/{id}/{slug}', [TaskController::class, 'update'])->name('task.update');
            Route::post('/task/store/{slug}', [TaskController::class, 'store'])->name('task.store');
            Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

            Route::get('/categories/{slug}/completed-tasks', [TaskController::class, 'completedTasks'])
                ->name('task.completed');
            Route::get('/categories/{slug}/tasks', [TaskController::class, 'filterTasks'])->name('tasks.filter');
        });

        require __DIR__ . '/auth.php';
    }
);
