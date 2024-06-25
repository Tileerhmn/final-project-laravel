<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
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
    return view('auth/login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/book', [BookController::class, 'index'])->name('book.index');
Route::get('/book/add', [BookController::class, 'create'])->name('book.create');
Route::post('/book', [BookController::class, 'store'])->name('book.store');
Route::get('/books/{isbn}/edit', [BookController::class, 'edit'])->name('book.edit');
Route::put('/books/{isbn}', [BookController::class, 'update'])->name('book.update');
Route::delete('/books/{isbn}', [BookController::class, 'destroy'])->name('book.destroy');

Route::get('/author', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/add', [AuthorController::class, 'create'])->name('authors.create');
Route::post('/author', [AuthorController::class, 'store'])->name('author.store');
Route::get('/authors/{id}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
Route::put('/authors/{id}', [AuthorController::class, 'update'])->name('authors.update');
Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');

Route::get('/categories', [CategoriesController::class, 'index'])->name('category.index');
Route::get('/categories/add', [CategoriesController::class, 'create'])->name('category.create');
Route::post('/categories', [CategoriesController::class, 'store'])->name('category.store');
Route::get('/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('category.edit');
Route::put('/categories/{id}/edit', [CategoriesController::class, 'update'])->name('category.update');
Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('category.destroy');

Route::get('/borrow', [BorrowingsController::class, 'index'])->name('borrowings.index');
Route::get('/borrows/add', [BorrowingsController::class, 'create'])->name('borrowings.create');
Route::post('/borrow', [BorrowingsController::class, 'store'])->name('borrowings.store');
Route::get('/borrow/{id}/edit', [BorrowingsController::class, 'edit'])->name('borrowings.edit');
Route::put('/borrow/{id}', [BorrowingsController::class, 'update'])->name('borrowings.update');
Route::delete('/borrow/{id}', [BorrowingsController::class, 'destroy'])->name('borrowings.destroy');
Route::put('/borrow/{id}/return', [BorrowingsController::class, 'returnbook'])->name('borrowings.return');

Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/users/add', [UserController::class, 'create'])->name('user.create');
Route::post('/users', [UserController::class, 'store'])->name('user.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
