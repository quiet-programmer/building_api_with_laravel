<?php

use App\Http\Controllers\API\Note\NoteAuthController;
use App\Http\Controllers\API\Note\NoteController;
use App\Http\Controllers\Test\AuthController;
use App\Http\Controllers\Test\ProductController;
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

Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function() {
    // Product route starts here
    Route::controller(ProductController::class)->group(function() {
        Route::post('/add_products', 'storeProducts')->name('product.store');
    });
    // ends here

    // auth route starts here
    Route::controller(AuthController::class)->group(function() {
        Route::post('/logout', 'logout');

        Route::get('/user', 'getUser');
    });
    // ends here
});

Route::controller(ProductController::class)->group(function() {
    Route::get('/products', 'allProducts')->name('product.all');
    Route::get('/products/search_product/{name}', 'searchProduct')->name('product.search');
});

// Note route
Route::controller(NoteAuthController::class)->group(function() {
    Route::post('/note/register', 'register');
    Route::post('/note/login', 'login');
});

Route::middleware('auth:sanctum')->group(function() {

    // Auth Route
    Route::controller(NoteAuthController::class)->group(function() {
        Route::get('/note/user', 'userInfo');
        Route::get('/note/check_plan', 'checkUserPlan');
        Route::post('/note/create_plan', 'createPlan');
        Route::post('/note/logout', 'logout');
    });
    // ends here

     // note routes
    Route::controller(NoteController::class)->group(function() {
        Route::get('notes/all_notes', 'allNotes');
        Route::post('notes/add_note', 'addNote');
        Route::put('notes/update_note/{id}', 'updateNote');
        Route::delete('notes/delete_note/{id}', 'deleteNote');
    });
    // ends here
});
