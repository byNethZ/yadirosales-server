<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PropertyController;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('activeAgents', [ApiController::class, 'activeAgents'])->middleware(Cors::class);
Route::get('agents', [ApiController::class, 'agents'])->middleware(Cors::class);
Route::get('offices', [ApiController::class, 'offices'])->middleware(Cors::class);
Route::get('units', [ApiController::class, 'units'])->middleware(Cors::class);
Route::get('rooms', [ApiController::class, 'rooms'])->middleware(Cors::class);
Route::get('openhouses', [ApiController::class, 'openhouses'])->middleware(Cors::class);
//Route::get('properties/{type}', [ApiController::class, 'properties'])->middleware(Cors::class);
//Route::get('properties/{type}', [PropertyController::class, 'propertiesByType'])->middleware(Cors::class);
