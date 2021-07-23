<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminCostController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\EthnogroupController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PsgcController;
use App\Http\Controllers\RecycleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

Route::get('clear', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('blank', function () {
    return view('blank');
});

Route::get('psgc/getProvinces', [PsgcController::class, 'getProvinces'])->name('getProvinces');
Route::get('psgc/getCities', [PsgcController::class, 'getCities'])->name('getCities');
Route::get('psgc/getBrgy', [PsgcController::class, 'getBrgy'])->name('getBrgy');
Route::get('ethnogroups/getEthnoGroups', [EthnogroupController::class, 'getEthnoGroups'])->name('getEthnoGroups');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/alumni', [ApplicationController::class, 'alumni'])->name('alumni');
    Route::get('/applications/applicationForm/{id}', [ApplicationController::class, 'applicationForm'])->name('applicationForm');
    Route::get('/applications/approved', [ApplicationController::class, 'approved'])->name('approved');
    Route::get('/applications/denied', [ApplicationController::class, 'denied'])->name('denied');
    Route::get('/applications/graduated', [ApplicationController::class, 'graduated'])->name('graduated');
    Route::get('/applications/newOnProcess', [ApplicationController::class, 'newOnProcess'])->name('newOnProcess');
    Route::get('/applications/terminated', [ApplicationController::class, 'terminated'])->name('terminated');
    Route::get('/applications/showAllApplication', [ApplicationController::class, 'showAllApplication'])->name('showAllApplication');
    Route::get('/applications/showAllApproved', [ApplicationController::class, 'showAllApproved'])->name('showAllApproved');
    Route::get('/applications/showAllNew/{id}', [ApplicationController::class, 'showAllNew'])->name('showAllNew');
    Route::get('/applications/showApproved/{id}', [ApplicationController::class, 'showApproved'])->name('showApproved');
    Route::get('/applications/showDenied/{id}', [ApplicationController::class, 'showDenied'])->name('showDenied');
    Route::get('/applications/showTerminated/{id}', [ApplicationController::class, 'showTerminated'])->name('showTerminated');
    Route::get('/applications/showOnProcess/{id}', [ApplicationController::class, 'showOnProcess'])->name('showOnProcess');
    Route::get('/applications/showGraduated/{id}', [ApplicationController::class, 'showGraduated'])->name('showGraduated');
    Route::get('/applications/noApplication', [UserController::class, 'noApplication'])->name('noApplication');
    Route::resource('applications', ApplicationController::class);

    Route::post('/applications/indexDT', [ApplicationController::class, 'indexDT']);
    Route::post('/users/indexDT', [UserController::class, 'indexDT']);

    Route::get('adminCost/{id}', [AdminCostController::class, 'showAdminCost'])->name('adminCost');
    Route::get('paymentToGrantee/{id}', [AdminCostController::class, 'showPaymentToGrantee'])->name('paymentToGrantee');
    Route::resource('costs', AdminCostController::class);
    Route::resource('calendars', CalendarController::class);


    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('admin');
    Route::get('/dashboard/executiveOfficer', [DashboardController::class, 'executiveOfficer'])->name('executiveOfficer');
    Route::get('/dashboard/regionalOfficer', [DashboardController::class, 'regionalOfficer'])->name('regionalOfficer');
    Route::get('/dashboard/provincialOfficer', [DashboardController::class, 'provincialOfficer'])->name('provincialOfficer');
    Route::get('/dashboard/communityOfficer', [DashboardController::class, 'communityOfficer'])->name('communityOfficer');
    Route::get('/dashboard/applicant', [DashboardController::class, 'applicant'])->name('applicant');
    Route::get('/dashboard/filter-chart', [DashboardController::class, 'filterChart']);

    Route::resource('dashboard', DashboardController::class);

    Route::get('/showAttachment/{grantID}/{userID}', [DocumentController::class, 'showAttachment'])->name('showAttachment');
    Route::post('/myDocumentUpload', [DocumentController::class, 'myDocumentStore'])->name('myDocumentUpload');
    Route::get('/myDocument', [DocumentController::class, 'myDocument'])->name('myDocument');
    Route::resource('documents', DocumentController::class);

    Route::resource('employments', EmploymentController::class);
    Route::resource('ethnogroups', EthnogroupController::class);
    Route::resource('grants', GrantController::class);
    Route::resource('profiles', ProfileController::class);

    Route::get('/recycle', [RecycleController::class, 'index'])->name('recycle');
    Route::get('/destroyApplication/{id}', [RecycleController::class, 'destroyApplication'])->name('destroyApplication');
    Route::get('/restoreApplication/{id}', [RecycleController::class, 'restoreApplication'])->name('restoreApplication');
    Route::get('/destroyGrant/{id}', [RecycleController::class, 'destroyGrant'])->name('destroyGrant');
    Route::get('/restoreGrant/{id}', [RecycleController::class, 'restoreGrant'])->name('restoreGrant');
    Route::get('/destroyUser/{id}', [RecycleController::class, 'destroyUser'])->name('destroyUser');
    Route::get('/restoreUser/{id}', [RecycleController::class, 'restoreUser'])->name('restoreUser');

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

    Route::post('/updateCredential', [UserController::class, 'updateCredential'])->name('updateCredential');
    Route::get('new-users', [UserController::class, 'newUser'])->name('newUser');
    Route::get('users/newAccount', [UserController::class, 'newAccount'])->name('newAccount');
    //Route::get('users/noApplication', [UserController::class, 'noApplication'])->name('noApplication');
    Route::get('users/eapFocal', [UserController::class, 'eapFocal'])->name('eapFocal');
    Route::get('users/student', [UserController::class, 'student'])->name('student');
    Route::resource('users', UserController::class);

    Route::get('/activity-logs', [DashboardController::class, 'activityLogs'])->name('activityLogs');
    Route::get('/activity-logs/clear', [DashboardController::class, 'clearActivityLogs'])->name('clearActivityLogs');

    Route::group(['prefix' => 'profile'], function () {
        Route::group(['prefix' => 'update'], function () {
            Route::get('show-modal', [ProfileController::class, 'showProfileModal']);
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => 'validate'], function () {
            Route::get('apply', [UserController::class, 'validateApply']);
        });
    });

    Route::get('storage/users-avatar/{userAvatar?}', [DashboardController::class, 'getImage']);
});
