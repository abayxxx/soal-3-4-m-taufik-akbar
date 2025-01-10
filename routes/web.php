<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});


//route for login
Route::get('/login', function () {
    return view('auth/login');
})->name('login');

//route for register
Route::get('/register', function () {
    return view('auth/register');
})->name('register');

//route for authentication
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/register', 'App\Http\Controllers\AuthController@register');


//route for prducts
Route::get('/products', 'App\Http\Controllers\ProductController@index')->middleware(['auth'])->name('products.index');
Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->middleware(['auth'])->name('products.create');
Route::post('/products/add', 'App\Http\Controllers\ProductController@store')->middleware(['auth'])->name('products.store');
Route::get('/products/{id}', 'App\Http\Controllers\ProductController@show')->middleware(['auth'])->name('products.show');
Route::get('/products/{id}/edit', 'App\Http\Controllers\ProductController@edit')->middleware(['auth'])->name('products.edit');
Route::put('/products/{id}', 'App\Http\Controllers\ProductController@update')->middleware(['auth'])->name('products.update');
Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@destroy')->middleware(['auth'])->name('products.destroy');
