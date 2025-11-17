<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MotoController;
use App\Http\Controllers\Api\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::apiResource('/motos', MotoController::class);  //cette route générée par resources fonctionne aussi


Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [MotoController::class, 'login']);
Route::get('/motos', [MotoController::class, 'index']);
Route::get('/motos/{id}', [MotoController::class, 'show']);
     
//Route::resource('articles', ArticleController::class);
Route::middleware('auth:sanctum')->group( function () {
    //Route::resource('articles', ArticleController::class);
    // Route::get('articles', [ArticleController::class, 'index']);
    Route::post('motos/', [MotoController::class, 'store']);
    Route::get('motos/edit/{id}', [MotoController::class, 'edit']);
    Route::put('motos/update/{id}', [MotoController::class, 'update']);
    Route::delete('motos/{id}', [MotoController::class, 'destroy']); 

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});