<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\BarangayOfficialController;
use App\Http\Controllers\BarangaySettingController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ResidentInformationController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\HomeController;


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
    return view('auth.login');
});


// ADMIN ACCOUNT
Route::group(['prefix' => 'admin', 'middleware' => ['is_admin']], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    // barangay
    Route::get('/barangay', [BarangayController::class, 'index'])->name('barangay');
    Route::post('/barangay/store', [BarangayController::class, 'store'])->name('barangay.store');
    Route::delete('/barangay/destroy', [BarangayController::class, 'destroy'])->name('barangay.destroy');

    // accounts
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');
    Route::delete('/account/destroy', [AccountController::class, 'destroy'])->name('account.destroy');

    // residents
    Route::get('/residents', [ResidentInformationController::class, 'adminResident'])->name('admin.resident');
});

// SECREATARY ACCOUNT
Route::group(['prefix' => 'barangay', 'middleware' => ['is_secretary']], function(){
    Route::get('/home', [SecretaryController::class, 'index'])->name('secretary.home');
    // residents
    Route::get('/resident', [ResidentInformationController::class, 'index'])->name('resident');
    //barangay officials
    Route::get('/officials', [BarangayOfficialController::class, 'index'])->name('barangay.officials');
    // barangay settings
    Route::get('/settings', [BarangaySettingController::class, 'index'])->name('setting');
    Route::post('/settings/update', [BarangaySettingController::class, 'saveSetting'])->name('update.setting');
    // blotters
    Route::get('/blotters', [BlotterController::class, 'index'])->name('barangay.blotter');
});


Auth::routes();