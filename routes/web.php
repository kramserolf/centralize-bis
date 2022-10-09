<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\BarangayOfficialController;
use App\Http\Controllers\BarangaySettingController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ResidentInformationController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\CertificateLayoutController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use App\Models\Barangay;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
// Route::controller(ResidentInformationController::class)
//     ->group(['prefix' => 'barangay', 'middleware' => ['is_secretary']], function(){
//     // residents
//     Route::get('/residents', 'index')->name('resident');
//     Route::post('/resident/store', 'store')->name('resident.store');
//     Route::delete('/resident/destroy', 'destroy')->name('resident.destroy');
//     Route::get('/resident/show', 'show')->name('resident.show');
// });
Route::group(['prefix' => 'barangay', 'middleware' => ['is_secretary']], function(){
    Route::get('/home', [SecretaryController::class, 'index'])->name('secretary.home');

    // residents
    Route::get('/residents', [ResidentInformationController::class, 'index'])->name('resident');
    Route::get('/households', [ResidentInformationController::class, 'household'])->name('household');
    Route::get('/senior-citizens', [ResidentInformationController::class, 'senior'])->name('senior');
    Route::post('/resident/store', [ResidentInformationController::class, 'store'])->name('resident.store');
    Route::delete('/resident/destroy', [ResidentInformationController::class, 'destroy'])->name('resident.destroy');
    Route::get('/resident/show', [ResidentInformationController::class, 'show'])->name('resident.show');

    //barangay officials
    Route::get('/officials', [BarangayOfficialController::class, 'index'])->name('barangay.officials');
    Route::post('/officials/store', [BarangayOfficialController::class, 'store'])->name('official.store');
    Route::delete('/officials/destroy', [BarangayOfficialController::class, 'destroy'])->name('official.destroy');

    // blotters
    Route::get('/blotters', [BlotterController::class, 'index'])->name('barangay.blotter');

    // barangay settings
    Route::get('/settings', [BarangaySettingController::class, 'index'])->name('setting');
    Route::post('/settings/update', [BarangaySettingController::class, 'saveSetting'])->name('update.setting');

    // zone
    Route::get('/zone', [ZoneController::class, 'index'])->name('barangay.zone');
    Route::post('/zone/store', [ZoneController::class, 'store'])->name('zone.store');
    Route::delete('/zone/destroy', [ZoneController::class, 'destroy'])->name('zone.destroy');

    // certificate layouts
    Route::get('/layouts', [CertificateLayoutController::class, 'index'])->name('barangay.layout');
    Route::post('/layouts', [CertificateLayoutController::class, 'store'])->name('layout.store');

    // Route::get('/home/{barangay}', function (Barangay $barangay) {
    //     $filter = DB::table('barangays as b')
    //                 ->leftJoin('accounts as a', 'b.id', 'a.barangay_id')
    //                 ->where('a.user_id', Auth::id())
    //                 ->first();

    //     $barangay = $filter->barangayName;

       
    // });
    

});

Auth::routes();