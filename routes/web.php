<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DicController;
use App\Http\Controllers\GmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\MasterReportController;

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

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/mmsy-dashboard', 'mmsyDashboard')->name('front-dashboard')->withoutMiddleware(['auth']);
    Route::get('/mmsy-dashboard/view/{fy}/{status_id}/{type}', 'extractFromCounts')->name('extractcounts')->withoutMiddleware(['auth']);
    Route::get('/grievances', 'grievancesForm')->name('grievances');
    Route::get('/login', 'login')->name('login');
    Route::get('/applicant-login', 'applicant_login')->name('login.applicant');
    Route::get('/faqs', 'faqs')->name('faqs');
    Route::post('/login', 'loginRequest')->name('login.request');
    Route::post('/grievance', 'grievance')->name('grievance.form');
    Route::post('/feedback', 'feedback')->name('feedback.form');
    Route::get('/recover-account', 'recover')->name('account.recover');
    Route::post('/send-otp', 'sendOtp')->name('otp.request');
    Route::get('/otp-login/{id}/{hash}', 'otpLogin')->name('otp.login');
    Route::post('/third_party_login', 'swcsLogin');
    if (env('APP_DEBUG', 'local') == 'local') {
        Route::get('/test', 'test')->name('home.test');
    }
});

Route::group(['prefix' => 'file-manager', 'middleware' => ['web', 'admin']], function () {
    Lfm::routes();
});

Route::middleware('auth')->group(function () {

    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

    Route::controller(ReportController::class)->prefix('/report')->group(function () {
        Route::get('/banks', 'banks')->name('report.banks');
        Route::get('/bank/{bank}', 'bank')->name('report.bank');
        Route::get('/bank-branch/{bankBranch}', 'bankBranch')->name('report.bank_branch');
        Route::get('/applications/{type}', 'applications')->name('report.applications')->whereIn('type', ['sponsored', 'pending', 'rejected', 'sanctioned']);
    });

    Route::controller(DashboardController::class)->prefix('/dashboard')->group(function () {
        Route::get('/notifications', 'notifications')->name('notification.list');

        Route::patch('/notification/{id}', 'readNotification')->name('notification.read');
        Route::delete('/notification/{id}', 'deleteNotification')->name('notification.destroy');
        Route::get('/', 'index')->name('dashboard');
        Route::get('/pendency/{statusId?}', 'pendency')->name('dashboard.pendency');
        Route::get('/schedule/{meeting?}', 'schedule')->name('dashboard.schedule');
        Route::get('/approved', 'approved')->name('dashboard.approved');
        Route::get('/pending', 'pending')->name('dashboard.pending');
        Route::post('/schedule-meeting', 'store')->name('schedule.meeting');

        Route::get('/reports', 'reports')->name('dashboard.reports');
        Route::get('/reports/{application}', 'report')->name('reports.show');
        Route::get('/reports/district/{id}', 'reportApplicationByDistrict')->name('reports.district');
        Route::get('/reports/constituency/{id}', 'reportApplicationByConstituency')->name('reports.constituency');
        Route::get('/reports/block/{id}', 'reportApplicationByBlock')->name('reports.block');

        Route::get('/meetings', 'meetingApplications')->name('dashboard.meetings');
        Route::get('/meetings/{meeting}', 'meetingApplication')->name('dashboard.meetings.application');
        Route::get('/agenda/{meeting}/{download?}', 'agenda')->name('dashboard.agenda');
        Route::get('/export-agenda/{meeting}', 'exportAgenda')->name('dashboard.agenda.export');
        Route::get('/minutes/{meeting}/{download?}', 'minutes')->name('dashboard.minutes');
        Route::put('/meetings/{meeting}', 'updateStatus')->name('dashboard.applications.status');
        Route::get('/db', 'db')->name('dashboard.db');
    });

    Route::controller(RegionController::class)->prefix('/regions')->group(function () {
        Route::get('/list/{type}', 'index')->name('regions.list')
            ->whereIn('type', ['constituency', 'tehsil', 'block-town', 'panchayat-ward']);
        Route::get('/create/{type}', 'create')->name('regions.create')
            ->whereIn('type', ['constituency', 'tehsil', 'block-town', 'panchayat-ward']);
        Route::post('/create/{type}', 'store')->name('regions.store')
            ->whereIn('type', ['constituency', 'tehsil', 'block-town', 'panchayat-ward']);
    });

    Route::controller(ApplicationController::class)->prefix('/application')->group(function () {
        Route::get('/view/{application}/{annexure?}/{applicationDocument?}', 'view')->name('application.view');
        Route::get('/withdraw/{application}', 'withdraw')->name('application.withdraw');
        Route::get('/get-data', 'get')->name('application.get')->withoutMiddleware(['auth']);
        Route::post('/save-data', 'saveData')->name('application.saveData')->withoutMiddleware(['auth']);
        Route::get('/dp/{application}', 'dp')->name('application.dp');
        Route::get('/annexure/{application}/{type?}/{download?}', 'annexure')->name('application.annexure');
        Route::get('/documents/{application}', 'documents')->name('application.documents');
        Route::get('/create/{form}/{formDesignId?}', 'create')->name('application.create')->withoutMiddleware(['auth']);
        Route::get('/new', 'new')->name('application.new')->withoutMiddleware(['auth']);
        Route::get('/newedit', 'newedit')->name('application.newedit');#->withoutMiddleware(['auth']);
        Route::get('/newdocument', 'newDocument')->name('newdocument');#->withoutMiddleware(['auth']);
        Route::get('/status', 'status')->name('application.newstatus')->withoutMiddleware(['auth']);
        Route::post('/newlogin', 'newlogin')->name('application.login')->withoutMiddleware(['auth']);
        Route::get('/edit/{application}/{formDesignId?}', 'edit')->name('application.edit');
        Route::get('/document/remove/{application}/{document}', 'documentRemove')->name('application.document-remove');
        Route::get('/document/{document}', 'document')->name('application.document');
        Route::post('/submit/{application}', 'submit')->name('application.submit');
        Route::post('/store/{form}/{formDesign}/{application?}', 'store')->name('application.store');
        Route::post('/upload/{application}/{documentType?}', 'upload')->name('application.upload')->withoutMiddleware(['auth']);
        Route::post('/upload-generic/{application}', 'uploadGeneric')->name('application.upload-generic');
        Route::put('/status/{application}', 'update')->name('application.status');
        Route::post('/updatecgtmse/{application}', 'updateCgtmse')->name('application.updateCgtmse');
        Route::get('/project-report/{application}/{download?}', 'preProjectReport')->name('application.ppr');
        Route::get('/details/{application}/{download?}', 'applicationDetails')->name('application.details');
        Route::post('/profile', 'saveProfile')->name('save.profile');
        Route::post('/credentials', 'saveCredentials')->name('save.credentials');
    });
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.list');

    Route::resource('dic-dh', DicController::class);
    Route::resource('gm', GmController::class);

    Route::controller(AjaxController::class)->prefix('/ajax/')->group(function () {
        Route::get('/get/{table}/{id}', 'get')->name('ajax.get');
        Route::get('/search/{table}', 'search')->name('ajax.search');
        Route::get('/load', 'load')->name('ajax.load')->withoutMiddleware(['auth']);
        Route::get('/count/{type?}', 'count')->name('ajax.count');
    });

    Route::controller(CrudController::class)->prefix('/crud/')->group(function () {
        Route::get('/{class}', 'index')->name('crud.list');
        Route::get('/create/{class}', 'create')->name('crud.create');
        Route::post('/store/{class}', 'store')->name('crud.store');
        Route::get('/edit/{class}/{id}', 'edit')->name('crud.edit');
        Route::post('/update/{class}/{id}', 'update')->name('crud.update');
        Route::post('/delete/{class}/{id}', 'delete')->name('crud.delete');
    });
    Route::controller(MasterReportController::class)->prefix('/master_report')->group(function () {
        Route::get('/applications/{type}/{step}', 'index')->name('master_report.applications')  ->where(['type' => 'sponsored|pending|rejected|sanctioned|cgtmse|all', 'step' => '60|40|0|1']);
        Route::post('/get-data-from-districts', [MasterReportController::class, 'getDataFromDistricts'])->name('get-data-from-districts');

    });
    Route::controller(MasterReportController::class)->prefix('/numaric_reports')->group(function () {
        Route::get('/application-recieved', 'recievedApplication')->name('numaric_reports.recieved');
        Route::get('/application-released', 'releasedApplication')->name('numaric_reports.released');
        Route::get('/export-recieved/{type}', 'exportReports')->name('numaric_reports.exportReports');
    });
});

