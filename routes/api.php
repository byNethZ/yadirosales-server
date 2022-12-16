<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PropertyController;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('properties/{type}', [PropertyController::class, 'propertiesByType']);
Route::get('properties', [PropertyController::class, 'getProperties']);
Route::get('home/{type}', [PropertyController::class, 'getPropertiesHome']);
Route::get('search/{feature}/{query}', [PropertyController::class, 'getPropertiesByQuery']);
Route::get('features', [PropertyController::class, 'getDataByColumn']);
Route::get('property/{id}', [PropertyController::class, 'getProperty']);

Route::get('results-counts', [PropertyController::class, 'getCountsResults']);

Route::post('contact', [PropertyController::class, 'sendMail']);

Route::get('images/{id}', [ApiController::class, 'images']);
Route::get('image/{id}', [ApiController::class, 'image']);

Route::get('consult/{type}/{status}', [ApiController::class, 'properties']);


//Preview Mail
Route::get('/mailable', function () {
    $data = [
        'firstname' => 'Nethz',
        'lastname' => 'Jimenez',
        'email' => 'correo@emailcom',
        'phone' => '9841533143',
        'message' => 'Texto de prueba',
        'typetour' => 'persona',
        'date' => '12/12/2022',
        'time' => 'Anytime',
    ];
    $property = Property::find(1);
    return new App\Mail\ContactMessage($data, $property);
});
