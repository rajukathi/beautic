<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags/save', [TagController::class, 'save']);
Route::get('/tags/delete/{id}', [TagController::class, 'delete']);

Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category/save', [CategoryController::class, 'save']);
Route::get('/category/delete/{id}', [CategoryController::class, 'delete']);

Route::get('/product', [ProductController::class, 'index']);
Route::post('/product/save', [ProductController::class, 'save']);
Route::get('/product/delete/{id}', [ProductController::class, 'delete']);
