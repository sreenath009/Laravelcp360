<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/create-form', [AdminController::class, 'createForm'])->name('admin.create_form');
    Route::post('/admin/save-form', [AdminController::class, 'saveForm'])->name('admin.save_form');
    Route::get('/admin/forms/{form}/edit', [AdminController::class, 'editForm'])->name('admin.edit_form');
    Route::post('/admin/forms/{form}/update', [AdminController::class, 'updateForm'])->name('admin.update_form');
    Route::post('/admin/forms/{form}/delete', [AdminController::class, 'deleteForm'])->name('admin.delete_form');
    Route::post('/admin/fields/{field}/delete', [AdminController::class, 'deleteField'])->name('admin.delete_field');
});

Route::get('/forms/{slug}', [FormController::class, 'showFormBySlug'])->name('public.show_form');
Route::post('/forms/{slug}/submit', [FormController::class, 'submitForm'])->name('public.submit_form');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
