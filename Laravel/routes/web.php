<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitorController;

// Главная страница с формой и списком
Route::get('/', [MonitorController::class, 'index'])->name('monitor.index');

// Сохранение нового или редактирование
Route::post('/save', [MonitorController::class, 'save'])->name('monitor.save');

// Поиск
Route::post('/find', [MonitorController::class, 'find'])->name('monitor.find');

// Удаление
Route::post('/delete/{id}', [MonitorController::class, 'delete'])->name('monitor.delete');

// Экспорт в CSV
Route::get('/export', [MonitorController::class, 'export'])->name('monitor.export');
