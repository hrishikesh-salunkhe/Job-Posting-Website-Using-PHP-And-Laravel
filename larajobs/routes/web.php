<?php

use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

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

//Fetch all Listings
Route::get('/', [ListingController::class, 'index']);

//Display create job listing form:
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store a new listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Display edit listing form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Submit the edit listing form
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete listing form
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage listings:
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//Fetch a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Display user registration form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create new user
Route::post('/users', [UserController::class, 'store']);

//Logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Display user login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);