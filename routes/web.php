<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\MedicalAssistantController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\AccountantController;           
            

	
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	
Route::group(['middleware' => 'auth'], function () {


	Route::get('/', function () {return redirect('/dashboard');});
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static'); 
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static'); 
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');


	Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
	Route::get('/pharmacist/dashboard', [PharmacistController::class, 'index'])->name('pharmacist.dashboard');
	Route::get('/medical-assistant/dashboard', [MedicalAssistantController::class, 'index'])->name('medical-assistant.dashboard');
	Route::get('/cashier/dashboard', [CashierController::class, 'index'])->name('cashier.dashboard');
	Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->name('accountant.dashboard');

});

//create auth group for all routes that require authentication
// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
//     Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
//     Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
//     Route::get('/{page}', [PageController::class, 'index'])->name('page');
//     Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// });

//create guest group for all routes that don't require authentication
// Route::group(['middleware' => 'guest'], function () {
//     Route::get('/register', [RegisterController::class, 'create'])->name('register');
//     Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
//     Route::get('/login', [LoginController::class, 'show'])->name('login');
//     Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
//     Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
//     Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');
//     Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
//     Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');
// });
?>