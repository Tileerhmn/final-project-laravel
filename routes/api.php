<?php

use App\Http\Controllers\api\AuthContoller;
use App\Http\Controllers\api\AuthorsController;
use App\Http\Controllers\api\BookBorrowingsController;
use App\Http\Controllers\api\BooksController;
use App\Http\Controllers\api\CategoriesController;
use App\Http\Controllers\api\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthContoller::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // logout
    Route::post('/logout', [AuthContoller::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:admin']], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);

    // categories
    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::get('/categories/{id}', [CategoriesController::class, 'show']);
    Route::post('/categories', [CategoriesController::class, 'store']);
    Route::put('/categrories/{id}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy']);

    // authors
    Route::get('/authors', [AuthorsController::class, 'index']);
    Route::get('/authors/{id}', [AuthorsController::class, 'show']);
    Route::post('/authors', [AuthorsController::class, 'store']);
    Route::put('/authors/{id}', [AuthorsController::class, 'update']);
    Route::delete('/authors/{id}', [AuthorsController::class, 'destroy']);

    // books
    Route::get('/books', [BooksController::class, 'index']);
    Route::get('/books/{id}', [BooksController::class, 'show']);
    Route::post('/books', [BooksController::class, 'store']);
    Route::post('/books/{id}', [BooksController::class, 'update']);
    Route::delete('/books/{id}', [BooksController::class, 'destroy']);
    Route::get('/books/search/{keyword}', [BooksController::class, 'search']);

    Route::post('borrowings', [BookBorrowingsController::class, 'store']);
    Route::get('borrowings', [BookBorrowingsController::class, 'index']);
    Route::get('borrowings/{id}', [BookBorrowingsController::class, 'show']);
    Route::put('borrowings/{id}', [BookBorrowingsController::class, 'update']);
    Route::delete('borrowings/{id}', [BookBorrowingsController::class, 'destroy']);
    Route::get('borrowings/search/{keyword}', [BookBorrowingsController::class, 'search']);
    Route::post('borrowings/return/{id}', [BookBorrowingsController::class, 'return']);
});
