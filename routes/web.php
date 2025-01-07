<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SignupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// #define route for access page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/signin', function () {
    return view('signin');
});

Route::get('/problem-timeline', function () {
    return view('problem');
});

Route::get('/reports/{slug}', [ReportController::class, 'show']);


// #define route for API call
Route::post('/submit', [SignupController::class, 'store'])->name('register.submit');

Route::post('/report/submit', [ReportController::class, 'createReport'])->name('report.submit');

Route::get('/reports', [ReportController::class, 'getReports'])->name('reports.index');
