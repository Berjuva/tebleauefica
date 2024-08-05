<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeficaController;
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


Route::get('/', [TeficaController::class, 'index']);
Route::post('/generate', [TeficaController::class, 'generate']);
Route::post('/export', [TeficaController::class, 'export']);
Route::get('/email', [TeficaController::class, 'emailForm']);
Route::post('/send-email', [TeficaController::class, 'sendEmail']);



// Route::get('/', function () {
//     return view('welcome');
// //  });
