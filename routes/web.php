<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\GeneralController;


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
Route::get('/apropos', function () {
    return view('apropos')->with('message', 'page à propos pour le test');
}); 
  Route::get('monopage', function () {
    return view('monopage');   
});  
 


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\GeneralController::class, 'index'])->name('index');
Route::post('/autocomplete', [MotoController::class,'autocomplete'])->name('autocomplete');
Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'index']);

Route::controller(MotoController::class)->group(function () {
    Route::get('/motos/{id}', 'show');
});
 
Auth::routes();


Route:: get ('/admin/motos', [MotoController::class, 'index'])->middleware('admin')->name('motos.index'); 
Route:: get ('/admin/motos/create', [MotoController::class, 'create'])->middleware('admin')->name('motos.create');
Route:: post ('/admin/motos/store', [MotoController::class, 'store'])->middleware('admin')->name('motos.store'); 
Route:: get ('/admin/motos/{id}', [MotoController::class, 'show'])->middleware('admin')->name('motos.show'); 
Route:: get ('/admin/motos/{id}/edit', [MotoController::class, 'edit'])->middleware('admin')->name('motos.edit'); 
Route:: patch ('/admin/motos/{id}/update', [MotoController::class, 'update'])->middleware('admin')->name('motos.update'); 
Route:: delete ('/admin/motos/{id}', [MotoController::class, 'destroy'])->middleware('admin')->name('motos.destroy'); 
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
