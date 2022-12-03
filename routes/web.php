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
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CertificateLayoutController;
use App\Http\Controllers\CertificateTypeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestController;
use App\Models\User;
use App\Models\Barangay;
use App\Models\Account;
use App\Models\ResidentInformation;
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
    Route::get('/profile', [HomeController::class, 'residentProfile'])->name('resident.profile');
    Route::post('/home/store', [RequestController::class, 'store'])->name('resident.request');
});

// ADMIN ACCOUNT
Route::group(['prefix' => 'admin', 'middleware' => ['is_admin']], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    // barangay
    Route::get('/barangay', [BarangayController::class, 'index'])->name('barangay');
    Route::get('/barangay/edit', [BarangayController::class, 'edit']);
    Route::post('/barangay/store', [BarangayController::class, 'store'])->name('barangay.store');
    Route::delete('/barangay/destroy', [BarangayController::class, 'destroy'])->name('barangay.destroy');

    // accounts
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/account/edit', [AccountController::class, 'edit']);
    Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');
    Route::delete('/account/destroy', [AccountController::class, 'destroy'])->name('account.destroy');

    // residents
    Route::get('/residents', [ResidentInformationController::class, 'adminResident'])->name('admin.resident');

    // blotter
    Route::get('/blotters', [BlotterController::class, 'adminIndex'])->name('admin.blotter');
    Route::get('/blotters/view', [BlotterController::class, 'viewBlotter']);

    Route::get('/reports', [FileController::class, 'adminindex'])->name('admin.reports');
    Route::get('report/download', [FileController::class, 'downloadCertificate'])->name('admin.certificate-download');

    Route::get('/profile', [HomeController::class, 'adminProfile'])->name('admin.profile');

    Route::get('announcements/', [AnnouncementController::class, 'adminAnnouncement'])->name('admin.announcements');
});


Route::group(['prefix' => 'barangay', 'middleware' => ['is_secretary']], function(){
    Route::get('/home', [SecretaryController::class, 'index'])->name('secretary.home');

    // residents
    Route::get('/residents', [ResidentInformationController::class, 'index'])->name('resident');
    Route::get('/resident/edit', [ResidentInformationController::class, 'edit'])->name('edit.resident');
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
    Route::get('/household/members', [ResidentInformationController::class, 'householdMembers']);

    //barangay officials
    Route::get('/officials', [BarangayOfficialController::class, 'index'])->name('barangay.officials');
    Route::get('/official/edit', [BarangayOfficialController::class, 'edit']);
    Route::post('/officials/store', [BarangayOfficialController::class, 'store'])->name('official.store');
    Route::delete('/officials/destroy', [BarangayOfficialController::class, 'destroy'])->name('official.destroy');

    // blotters
    Route::get('/blotters', [BlotterController::class, 'index'])->name('barangay.blotter');
    Route::get('/blotters/edit', [BlotterController::class, 'edit']);
    Route::post('/blotters/store', [BlotterController::class, 'store'])->name('blotter.store');
    Route::delete('/blotter/destroy', [BlotterController::class, 'destroy']);

    // barangay settings
    Route::get('/settings', [BarangaySettingController::class, 'index'])->name('setting');
    Route::post('/settings/update', [BarangaySettingController::class, 'saveSetting'])->name('update.setting');

    // zone
    Route::get('/zone', [ZoneController::class, 'index'])->name('barangay.zone');
    Route::get('/zone/edit', [ZoneController::class, 'edit']);
    Route::post('/zone/store', [ZoneController::class, 'store'])->name('zone.store');
    Route::delete('/zone/destroy', [ZoneController::class, 'destroy'])->name('zone.destroy');

    // annoucements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('barangay.announcement');
    Route::get('general/announcements/', [AnnouncementController::class, 'secretaryAnnouncement'])->name('barangay.announcements');
    Route::get('/announcement/edit', [AnnouncementController::class, 'edit']);
    Route::post('/announcement/store', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::post('/announcement/update', [AnnouncementController::class, 'update'])->name('announcement.update');
    Route::delete('/announcement/destroy', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');

    // certificate types
    Route::get('/certificate-types', [CertificateTypeController::class, 'index'])->name('certificate.type');
    Route::get('/certificate-types/edit', [CertificateTypeController::class, 'edit']);
    Route::post('/certificate-types', [CertificateTypeController::class, 'store'])->name('type.store');
    Route::delete('/certificate-types', [CertificateTypeController::class, 'destroy'])->name('type.destroy');

    // certificate layouts
    Route::get('/certificate-layouts', [CertificateLayoutController::class, 'index'])->name('barangay.layout');
    Route::get('/certificate-layout/edit', [CertificateLayoutController::class, 'edit']);
    Route::post('/certificate-layouts', [CertificateLayoutController::class, 'store'])->name('layout.store');
    Route::delete('/certificate-layout/destroy', [CertificateLayoutController::class, 'destroy']);
    


    // issued certificates
    Route::get('/residents/issue-certificate', [ResidentInformationController::class, 'getCertificateLayout'])->name('get-certificate.layout');
    Route::get('/resident/select-certificate', [ResidentInformationController::class, 'edit'])->name('resident.select-certificate');
    Route::post('/resident/issue-certificate', [ResidentInformationController::class, 'issueCertificate'])->name('issue-certificate.store');

    // certificates
    Route::get('reports/certificates', [CertificateController::class, 'index'])->name('certificate.reports');

    Route::get('/reports/files', [FileController::class, 'index'])->name('report.file');
    Route::post('/reports/files', [FileController::class, 'store'])->name('report.store-file');
    Route::delete('/report/file/destroy', [FileController::class, 'destroy']);

    Route::get('/profile', [HomeController::class, 'secretaryProfile'])->name('secretary.profile');

    // certificate requests
    Route::get('/certificate/requests', [RequestController::class, 'index'])->name('certificate.requests');
    Route::post('/certificate/requests', [RequestController::class, 'approveCertificate'])->name('approve.certificate');
    Route::delete('certificates/request/destroy', [RequestController::class, 'destroy']);

    // Route::get('/home/{barangay}', function (Barangay $barangay) {
    //     $filter = DB::table('barangays as b')
    //                 ->leftJoin('accounts as a', 'b.id', 'a.barangay_id')
    //                 ->where('a.user_id', Auth::id())
    //                 ->first();

    //     $barangay = $filter->barangayName;

       
    // });

    Route::get('certificate/download', [CertificateController::class, 'downloadCertificate'])->name('certificate.download');
 
    

});

Route::middleware(['auth'])->group(function () {
    Route::put('/profile/update', [HomeController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/password/update', [HomeController::class, 'passwordUpdate'])->name('password.update');
});

Auth::routes([
    'register' => false,
    'reset' => false, 
    'verify' => false, 
]);