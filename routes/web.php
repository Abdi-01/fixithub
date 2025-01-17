<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\SolutionController;

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

Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/reports', [ReportController::class, 'getReports'])->name('reports.index');

Route::post('/report/submit', [ReportController::class, 'createReport'])->name('report.submit');

Route::post('/report/for/{slug}', [ReportController::class, 'createReport'])->name('report.for');

Route::post('/report/feedback/rating/{slug}', [ReportController::class, 'createFeedbackRating'])->name('report.feedback');

Route::post('/report/verify/{slug}', [ReportController::class, 'verifyReport'])->name('report.verify');

Route::post('/discussion/{slug}/submit', [DiscussionController::class, 'cretaeMessage'])->name('discussion.submit');

Route::post('/solution/{slug}/submit', [SolutionController::class, 'createSolution'])->name('solution.submit');

Route::post('/solution/update/{reportIdSlug}/{solutionIdSlug}', [SolutionController::class, 'updateSolutionStatus'])->name('solution.update');
