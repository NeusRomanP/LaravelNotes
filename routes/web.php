<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/notes', [App\Http\Controllers\NoteController::class, 'index'])->name('notes.index');

Route::get('/notes/create', [App\Http\Controllers\NoteController::class, 'create'])->name('note.create');

Route::post('/notes', [App\Http\Controllers\NoteController::class, 'store'])->name('note');

Route::get('/notes/{id}', [App\Http\Controllers\NoteController::class, 'show'])->name('show');

Route::post('/notes/{id}', [App\Http\Controllers\NoteController::class, 'update'])->name('note.update');

Route::get('/notes/delete/{id}', [App\Http\Controllers\NoteController::class, 'destroy'])->name('note.delete');

Route::post('/notes/{id}/{user}', [App\Http\Controllers\NoteController::class, 'getUsers'])->name('note.users');