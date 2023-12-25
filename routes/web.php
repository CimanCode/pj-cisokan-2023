<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\GrievanceController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', function () {
//     return view('Layout.app');
// });

// Route::get('/', [MapController::class, 'index'])->name('baseMap');
Route::any('/logout',[AuthController::class, 'logout'])->name('logout');
Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::get('/petugasmap', [PetugasController::class, 'mappetugas'])->name('petugasmap')->middleware('isPetugas');
Route::get('/riwayat', [PetugasController::class, 'index'])->name('riwayat')->middleware('isPetugas');

Route::post('/addGrievance',[GrievanceController::class, 'create_grievance'])->name('add_grievance')->middleware('isPetugas');
Route::any('/edit',[GrievanceController::class, 'edit'])->name('edit_grievance')->middleware('isPetugas');
Route::get('/detail_grievance',[GrievanceController::class, 'detail'])->name('detail')->middleware('isPetugas');
Route::get('/delete',[GrievanceController::class, 'delete'])->name('delete')->middleware('isPetugas');
Route::get('/',[GrievanceController::class, 'index'])->name('home');

Route::get('/admin', [AdminController::class, 'index'])->name('adminMap')->middleware('isAdmin');

Route::get('/getKmlFile', [MapController::class, 'getMap']);

