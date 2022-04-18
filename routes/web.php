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

//Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Auth::routes(['register' => false]);

// this will let laravel automatically redirect again if already logged in
Route::permanentRedirect('/', '/login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::resource('empresa', App\Http\Controllers\CompanyController::class);
Route::get('/empresa', [App\Http\Controllers\CompanyController::class, 'index'])->name('company');
Route::get('/empresa/cadastrar', [App\Http\Controllers\CompanyController::class, 'create'])->name('create_company');
Route::get('/empresa/editar/{id_company}', [App\Http\Controllers\CompanyController::class, 'edit'])->name('edit_company');
Route::get('/empresa/visualizar/{id_company}', [App\Http\Controllers\CompanyController::class, 'show'])->name('show_company');
Route::post('/empresa/cadastrar', [App\Http\Controllers\CompanyController::class, 'store'])->name('store_company');
Route::put('/empresa/editar/{id_company}', [App\Http\Controllers\CompanyController::class, 'update'])->name('update_company');
Route::delete('/empresa/{id_company}', [App\Http\Controllers\CompanyController::class, 'destroy'])->name('delete_company');

Route::get('/usuario', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::get('/usuario/cadastrar', [App\Http\Controllers\UserController::class, 'create'])->name('auth.register');
Route::get('/usuario/editar/{id_user}', [App\Http\Controllers\UserController::class, 'edit'])->name('edit_user');
Route::get('/usuario/visualizar/{id_user}', [App\Http\Controllers\UserController::class, 'show'])->name('show_user');
Route::post('/usuario/cadastrar', [App\Http\Controllers\UserController::class, 'store'])->name('store_user');
Route::put('/usuario/editar/{id_user}', [App\Http\Controllers\UserController::class, 'update'])->name('update_user');
Route::delete('/usuario/{id_user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('delete_user');
