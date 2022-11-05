<?php

use App\Http\Controllers\ImagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard',[PostController::class,'index'])->middleware(['auth','verified'])->name('dashboard');


Route::get('/post/create/',[PostController::class,'create'])->middleware(['auth','verified'])->name('poster');


Route::post('/poster',[PostController::class,'store'])->middleware(['auth','verified'])->name('poster.create');

Route::get('/post/{post}',[PostController::class,'show'])->middleware(['auth','verified'])->name('post.show');
Route::delete('/post/{post}',[PostController::class,'destroy'])->middleware(['auth','verified'])->name('post.delete');

require __DIR__.'/auth.php';


//     Profile //////////
Route::get('profile/{user}/',[ProfileController::class,'create'])->name('profile.user')->middleware(['auth','verified']);
Route::put('profile/{user}/update', [ProfileController::class, 'update'])
    ->name('users.update')
    ->middleware(['auth','verified']);


// Posts ////



















// Image Route


Route::get('/img/{path}',[ImagesController::class,'show'])->where('path', '.*')
->name('image');
