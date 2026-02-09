<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitorController;

// Главная страница с формой
Route::get('/', [MonitorController::class, 'index'])->name('monitor.index');

// Обработка сохранения
Route::post('/save', [MonitorController::class, 'save'])->name('monitor.save');

// Обработка поиска
Route::post('/find', [MonitorController::class, 'find'])->name('monitor.find');
