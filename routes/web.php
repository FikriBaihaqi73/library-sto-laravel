<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/scan', function () {
    return view('scan');
})->name('scan');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/books', function () {
    return view('admin.books.index');
})->name('admin.books.index');

Route::get('/admin/users', function () {
    return view('admin.users.index');
})->name('admin.users.index');
