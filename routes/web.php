<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminCostController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EthnogroupController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PsgcController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'checker']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('blank', function () {
    return view('blank');
});

Route::get('psgc/getProvinces', [PsgcController::class, 'getProvinces'])->name('getProvinces');
Route::get('psgc/getCities', [PsgcController::class, 'getCities'])->name('getCities');
Route::get('psgc/getBrgy', [PsgcController::class, 'getBrgy'])->name('getBrgy');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/applications/showApproved/{id}', [ApplicationController::class, 'showApproved'])->name('showApproved');
    Route::get('/applications/showTerminated/{id}', [ApplicationController::class, 'showTerminated'])->name('showTerminated');
    Route::get('/applications/showOnProcess/{id}', [ApplicationController::class, 'showOnProcess'])->name('showOnProcess');
    Route::resource('applications', ApplicationController::class);

    Route::resource('costs', AdminCostController::class);
    Route::resource('calendars', CalendarController::class);

    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('admin');
    Route::get('/dashboard/executiveOfficer', [DashboardController::class, 'executiveOfficer'])->name('executiveOfficer');
    Route::get('/dashboard/regionalOfficer', [DashboardController::class, 'regionalOfficer'])->name('regionalOfficer');
    Route::get('/dashboard/provincialOfficer', [DashboardController::class, 'provincialOfficer'])->name('provincialOfficer');
    Route::get('/dashboard/communityOfficer', [DashboardController::class, 'communityOfficer'])->name('communityOfficer');
    Route::get('/dashboard/applicant', [DashboardController::class, 'applicant'])->name('applicant');
    Route::resource('dashboard', DashboardController::class);

    Route::resource('documents', DocumentController::class);
    Route::resource('ethnogroups', EthnogroupController::class);
    Route::resource('grants', GrantController::class);
    Route::resource('profiles', ProfileController::class);
    Route::get('/reports/formA', [ReportController::class, 'formA'])->name('formA');
    Route::get('/reports/formB', [ReportController::class, 'formB'])->name('formB');
    Route::get('/reports/formC', [ReportController::class, 'formC'])->name('formC');
    Route::get('/reports/formD', [ReportController::class, 'formD'])->name('formD');
    Route::get('/reports/formE', [ReportController::class, 'formE'])->name('formE');
    Route::get('/reports/formF', [ReportController::class, 'formF'])->name('formF');
    Route::get('/reports/formG', [ReportController::class, 'formG'])->name('formG');
    Route::get('/reports/formH', [ReportController::class, 'formH'])->name('formH');
    Route::resource('reports', ReportController::class);
    Route::resource('requirements', RequirementController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('storage/users-avatar/{userAvatar?}', [DashboardController::class, 'getImage']);
});
