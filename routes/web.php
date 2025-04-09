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
	use App\Http\Controllers\DrugController;
	use App\Http\Controllers\SupplierController;
	use App\Http\Controllers\StockController;
	use App\Http\Controllers\RoleController;

	Route::get('/', function () {return view('auth.login');});
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	
Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/user-management', [PageController::class, 'userManagement'])->name('user-management');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static'); 
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static'); 
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');

	Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
	Route::get('/pharmacist/dashboard', [PharmacistController::class, 'index'])->name('pharmacist.dashboard');
	Route::get('/medical-assistant/dashboard', [MedicalAssistantController::class, 'index'])->name('medical-assistant.dashboard');
	Route::get('/cashier/dashboard', [CashierController::class, 'index'])->name('cashier.dashboard');
	Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->name('accountant.dashboard');

	//Pharmacist Routes
	Route::get('/pharmacist/{id}/edit',[PharmacistController::class, 'edit'])->name('pharmacist.edit');
	Route::get('/pharmacist/{id}', [PharmacistController::class, 'destroy'])->name('pharmacist.destroy');
	Route::get('/pharmacist/add', [PharmacistController::class, 'create'])->name('pharmacist.add');

	Route::get('/drugs', [DrugController::class, 'index'])->name('drugs.index');
    Route::get('/drugs/add', [DrugController::class, 'addDrug'])->name('drugs.add');
    Route::post('/drugs/add', [DrugController::class, 'storeDrug'])->name('drugs.store');
    Route::get('/drugs/set-price', [DrugController::class, 'setSellingPriceForm'])->name('drugs.set_price');
    Route::post('/drugs/{drug}/set-price', [DrugController::class, 'updateSellingPrice'])->name('drugs.setprice.update');
	// In routes/web.php
	Route::get('drugs/{drug}/edit', [DrugController::class, 'edit'])->name('drugs.edit');// In routes/web.php
	Route::get('drugs/{drug}/sell', [DrugController::class, 'sell'])->name('drugs.sell');
	Route::put('drugs/{drug}', [DrugController::class, 'update'])->name('drugs.update');
	Route::delete('drugs/{drug}/delete', [DrugController::class, 'destroy'])->name('drugs.destroy');

	Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
	Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
	Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
	Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
	Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
	Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

	Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
	Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
	Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
	Route::get('/stock/{stockEntry}/edit', [StockController::class, 'edit'])->name('stock.edit');
	Route::put('/stock/{stockEntry}', [StockController::class, 'update'])->name('stock.update');
	Route::delete('/stock/{stockEntry}', [StockController::class, 'destroy'])->name('stock.destroy');
	//View Inventory Stock
	Route::get('/inventory-stock', [StockController::class, 'inventory'])->name('inventory.stock');
	Route::post('/stock-orders', [StockController::class, 'store_order'])->name('stock_orders.store');

	Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
	Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
	Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
	Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
	Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
	Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');


	//Register new user
	Route::get('/user-management', [App\Http\Controllers\UserController::class, 'index'])->name('user-management');
	Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
	Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
	Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
	Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

	
	
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
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