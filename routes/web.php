<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\listingController;

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
//show all listings
Route::get('/', [listingController::class,'index']);

//show create listing form
Route::get('/listings/create', [listingController::class,'create'])->middleware('auth');

//store listing data
Route::post('/listings', [listingController::class,'store']);

//manage listing
Route::get('/listings/manage', [listingController::class,'manage'])->middleware('auth');

//update edit form
Route::put('/listings/{listing}', [listingController::class,'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}', [listingController::class,'destroy'])->middleware('auth');

//show listing
Route::get('/listings/{listing}', [listingController::class,'show']);

//show edit form
Route::get('/listings/{listing}/edit', [listingController::class,'edit'])->middleware('auth');


//show register user form
Route::get('/register', [UserController::class,'create'])->middleware('guest');

//register user
Route::post('/user', [UserController::class,'store']);

//logout user
Route::post('/logout', [UserController::class,'logout'])->middleware('auth');

//login user form
Route::get('/login', [UserController::class,'login'])->name('login')->middleware('guest');

//login user
Route::post('/users/authenticate', [UserController::class,'authenticate']);

// Route::get('/listings/{id}', function($id){
//     $listing = Listing::find($id);
//     if($listing){
//     return view('listing',[
//         'listing' => $listing
//     ]
//     );
// }else{
//     abort('404');
// }
// });

// Route::get('/hello', function () {
//     return 'salam alikoum';
// });

// Route::get('/search' ,function(Request $request){
//     return $request->name .' '.$request->city;
// });

