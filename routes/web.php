<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\BarangayOfficialController;
use App\Http\Controllers\BarangaySettingController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ResidentInformationController;
use App\Http\Controllers\ResidentAccountController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CertificateLayoutController;
use App\Http\Controllers\CertificateTypeController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use App\Models\Barangay;
use App\Models\Account;
use Database\Factories\ResidentInformationFactory;
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

// RESIDENT ACCOUNT
Route::group(['prefix' => 'resident', 'middleware' => ['is_resident']], function(){
    Route::get('/home', [HomeController::class, 'residentHome'])->name('resident.home');
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

    // blotter
    Route::get('/blotters', [BlotterController::class, 'adminIndex'])->name('admin.blotter');
});

Route::group(['prefix' => 'barangay', 'middleware' => ['is_secretary']], function(){
    Route::get('/home', [SecretaryController::class, 'index'])->name('secretary.home');

    // residents
    Route::get('/residents', [ResidentInformationController::class, 'index'])->name('resident');
    // resident accounts
    Route::get('/resident-accounts', [ResidentAccountController::class, 'index'])->name('barangay.resident_account');
    Route::delete('/resident-account/destroy', [ResidentAccountController::class, 'destroy'])->name('resident_account.destroy');
    // generate resident account
    Route::post('/residents', [ResidentAccountController::class, 'store'])->name('resident.account');

    Route::get('/households', [ResidentInformationController::class, 'household'])->name('household');
    Route::get('/senior-citizens', [ResidentInformationController::class, 'senior'])->name('senior');
    Route::post('/resident/store', [ResidentInformationController::class, 'store'])->name('resident.store');
    Route::delete('/resident/destroy', [ResidentInformationController::class, 'destroy'])->name('resident.destroy');
    Route::get('/resident/show', [ResidentInformationController::class, 'show'])->name('resident.show');
    Route::get('/residents/per-zone', [ResidentInformationController::class, 'residentPerZone'])->name('resident.per-zone');
    Route::get('/resident/filter-by-zone', [ResidentInformationController::class, 'filterZone'])->name('filter.zone');
    Route::get('/resident/zone/search', [ResidentInformationController::class, 'search']);

    //barangay officials
    Route::get('/officials', [BarangayOfficialController::class, 'index'])->name('barangay.officials');
    Route::post('/officials/store', [BarangayOfficialController::class, 'store'])->name('official.store');
    Route::delete('/officials/destroy', [BarangayOfficialController::class, 'destroy'])->name('official.destroy');

    // blotters
    Route::get('/blotters', [BlotterController::class, 'index'])->name('barangay.blotter');
    Route::post('/blotters/store', [BlotterController::class, 'store'])->name('blotter.store');
    Route::delete('/blotter/destroy', [BlotterController::class, 'destroy']);

    // barangay settings
    Route::get('/settings', [BarangaySettingController::class, 'index'])->name('setting');
    Route::post('/settings/update', [BarangaySettingController::class, 'saveSetting'])->name('update.setting');

    // zone
    Route::get('/zone', [ZoneController::class, 'index'])->name('barangay.zone');
    Route::post('/zone/store', [ZoneController::class, 'store'])->name('zone.store');
    Route::delete('/zone/destroy', [ZoneController::class, 'destroy'])->name('zone.destroy');

    // annoucements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('barangay.announcement');
    Route::post('/announcement/store', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::delete('/announcement/destroy', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');

    // certificate types
    Route::get('/certificate-types', [CertificateTypeController::class, 'index'])->name('certificate.type');
    Route::post('/certificate-types', [CertificateTypeController::class, 'store'])->name('type.store');
    Route::delete('/certificate-types', [CertificateTypeController::class, 'destroy'])->name('type.destroy');

    // certificate layouts
    Route::get('/certificate-layouts', [CertificateLayoutController::class, 'index'])->name('barangay.layout');
    Route::post('/certificate-layouts', [CertificateLayoutController::class, 'store'])->name('layout.store');

    // issued certificates
    Route::get('/residents/issue-certificate', [ResidentInformationController::class, 'getCertificateLayout'])->name('get-certificate.layout');
    Route::get('/resident/select-certificate', [ResidentInformationController::class, 'edit'])->name('resident.select-certificate');
    Route::post('/resident/issue-certificate', [ResidentInformationController::class, 'issueCertificate'])->name('issue-certificate.store');



    // Route::get('/home/{barangay}', function (Barangay $barangay) {
    //     $filter = DB::table('barangays as b')
    //                 ->leftJoin('accounts as a', 'b.id', 'a.barangay_id')
    //                 ->where('a.user_id', Auth::id())
    //                 ->first();

    //     $barangay = $filter->barangayName;

       
    // });
    

});

Auth::routes();