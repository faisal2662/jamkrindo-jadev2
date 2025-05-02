<?php


use App\Models\Branch;
use App\Models\Percakapan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportDWHController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\LoginCustomerController;
use App\Http\Controllers\NewManagementController;
use App\Http\Controllers\CityManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BranchManagementController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\ChattingManagementController;
use App\Http\Controllers\CustomerManagementController;
use App\Http\Controllers\ProvinceManagementController;
use App\Http\Controllers\RegionOfManagementController;
use App\Http\Controllers\RegionOffManagementController;
use App\Http\Controllers\ChattingCustomerManagementController;

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

    return view('auth.login-customer');
});

// get hris api
Route::get('/jamkrindo/get-hris', [UserManagementController::class, 'getApi']);
// Route::get('/fetchdata/{token}', [UserManagementController::class, 'fetchAllData']);

Route::get('/admin', [LoginController::class, 'index'])->name('login');
Route::post('/admin/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/admin/cek-data', [LoginController::class, 'cekData'])->name('login.cek_data');
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin/registrasi', function () {
    return view('auth.registrasi');
});
Route::get('/admin/otp/{id}/{kd_user}', [LoginController::class, 'confirm'])->name('login.confirm');
Route::post('/admin/verify-otp', [LoginController::class, 'verifyOtp'])->name('login.verifyOtp');

Route::get('/login', [LoginCustomerController::class, 'index'])->name('login-customer');
Route::post('/login', [LoginCustomerController::class, 'authenticate'])->name('authenticate-customer');
Route::post('/registrasi', [LoginCustomerController::class, 'registrasiStore'])->name('registrasi-customer');

Route::get('/logout', [LoginCustomerController::class, 'logout'])->name('logout-customer');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [LoginController::class, 'forgotPasswordSend'])->name('forgot.password.send');
Route::get('/reset-password/{token}/{email}', [LoginController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'updatePassword'])->name('password.update');
Route::get('/customer/registrasi', [LoginCustomerController::class, 'registrasi'])->name('registrasi');
Route::get('/customer/otp/{id}/{kd_user}', [LoginCustomerController::class, 'confirm'])->name('login.confirm-customer');
Route::post('/customer/verify-otp', [LoginCustomerController::class, 'verifyOtp'])->name('login.verifyOtp-customer');
Route::get('/icons', [CategoryProductController::class, 'showIconGallery'])->name('show_icon');
Route::get('dashboard', function () {
    return view('index');
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/customer/profile', [CustomerManagementController::class, 'profile'])->name('profile-customer');
    Route::post('/customer/profile/{id}', [CustomerManagementController::class, 'profileUpdate'])->name('profile-update-customer');
    Route::post('/customer/change-password/{id}', [CustomerManagementController::class, 'changePassword'])->name('change-password-customer');
    Route::get('/customer/profile', [CustomerManagementController::class, 'profile'])->name('profile-customer');
    Route::get('/customer/dashboard', [DashboardController::class, 'index'])->name('dashboard-customer');
    Route::post('/update/cabang', [LoginCustomerController::class, 'updateCabang'])->name('updateCabang');

    Route::get('/chat-customer', [ChattingCustomerManagementController::class, 'index'])->name('chat-customer');

    //Route::get('/chat-customer', function () {
    //    $regions = Branch::where('id_cabang', Auth::user()->kd_cabang)->first();
    //    $percakapan = Percakapan::where('kd_cabang', Auth::user()->kd_cabang)->first();
    //    return view('customer-chat.index', compact('regions', 'percakapan'));
    //})->name('chat-customer');

    Route::get('/customer/chat', [ChattingCustomerManagementController::class, 'index'])->name('chat');
    Route::post('/customer/conversations', [ChattingCustomerManagementController::class, 'createConversation']);
    Route::post('/customer/messages', [ChattingCustomerManagementController::class, 'sendMessage'])->name('sendMessageCustomer');
    Route::get('/customer/conversations/{id}/messages', [ChattingCustomerManagementController::class, 'getMessages']);
    Route::get('/customer/get-conversations', [ChattingCustomerManagementController::class, 'getConversations']);
    Route::get('/customer/conversation/read-message', [ChattingCustomerManagementController::class, 'readMessage'])->name('chat-read-customer');
    Route::get('/customer/chat/unread-conversation', [ChattingCustomerManagementController::class, 'unreadConversation'])->name('chat-unread');
    // Route::get('/customer/conversations', [ChattingCustomerManagementController::class, 'getConversations']);
    // Route::get('/customer/conversation/read-message', [ChattingCustomerManagementController::class, 'readMessage'])->name('chat-read-customer');
    Route::post('/customer/upload-file', [ChattingCustomerManagementController::class, 'uploadFile'])->name('upload-file-customer');
    Route::get('/customer/check-receive', [ChattingCustomerManagementController::class, 'checkReceive'])->name('check-receive-customer');
    Route::get('/customer/fetch-messages', [ChattingCustomerManagementController::class, 'fetchMessages']);
    Route::get('/customer/warning-messages', [ChattingCustomerManagementController::class, 'warningMessages']);
    Route::post('customer/chat/chat-reply', [ChattingCustomerManagementController::class, 'chatReply'])->name('chat-reply.customer');
    Route::post('customer/chat/check-conversation', [ChattingCustomerManagementController::class, 'checkConversation'])->name('check-conversation.customer');
});
Route::get('/get-data-kota/{id}', [CityManagementController::class, 'getDataKota'])->name('getDataKota');
Route::get('/get-data-wilayah/{id}', [RegionOfManagementController::class, 'getDataWilayah'])->name('getDataWilayah');
Route::get('/get-data-cabang/{id}', [BranchManagementController::class, 'getDataCabang'])->name('getDataCabang');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'master-akses', 'as' => 'master-akses.'], function () {
        Route::get('/', [AccessController::class, 'index'])->name('index');
    });



    Route::get('/get-data-kota', [CityManagementController::class, 'getDataKotaAll'])->name('getDataKotaAll');

    Route::get('/profile', [UserManagementController::class, 'profile'])->name('profile');
    Route::post('/profile/{id}', [userManagementController::class, 'profileUpdate'])->name('profile-update');
    Route::post('/change-password/{id}', [userManagementController::class, 'changePassword'])->name('change-password');
    Route::group(['prefix' => 'users-management', 'as' => 'user-manager.'], function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');

        Route::get('/get-data', [UserManagementController::class, 'getData'])->name('getData');
        Route::get('/tambah', [UserManagementController::class, 'create'])->name('create');
        Route::get('/lihat/{id}', [UserManagementController::class, 'show'])->name('show');
        Route::post('/tambah', [UserManagementController::class, 'store'])->name('save');
        Route::post('/export-pdf', [UserManagementController::class, 'cetakPdf'])->name('pdf');
        Route::post('/export-excel', [UserManagementController::class, 'cetakExcel'])->name('excel');
        Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [UserManagementController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [UserManagementController::class, 'destroy'])->name('delete');
        Route::get('/page-get-api', [UserManagementController::class, 'pageApi'])->name('get-api');
        Route::get('/get-api', [UserManagementController::class, 'getApi'])->name('getApi');
        Route::get('/get-log-user', [UserManagementController::class, 'getLoguser'])->name('getLogUser');
        Route::get('/get-log', [UserManagementController::class, 'getLog'])->name('getLog');
        Route::post('/sync-data', [UserManagementController::class, 'getApi'])->name('user-sync');
        Route::get('/lastsync', [UserManagementController::class, 'lastSync'])->name('last-sync');
    });


    Route::group(['prefix' => 'products-management', 'as' => 'product-manager.'], function () {
        Route::get('/', [ProductManagementController::class, 'index'])->name('index');
        Route::get('/get-data', [ProductManagementController::class, 'getData'])->name('getData');
        Route::get('/tambah', [ProductManagementController::class, 'create'])->name('create');
        Route::post('/tambah', [ProductManagementController::class, 'store'])->name('save');
        Route::post('/upload-image', [ProductManagementController::class, 'uploadGambar'])->name('uploadImage');
        Route::get('/edit/{id}', [ProductManagementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProductManagementController::class, 'update'])->name('update');
        Route::get('/lihat/{id}', [ProductManagementController::class, 'show'])->name('show');
        Route::get('/delete/{id}', [ProductManagementController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'news-management', 'as' => 'news-manager.'], function () {
        Route::get('/', [NewManagementController::class, 'index'])->name('index');
        Route::get('/get-data', [NewManagementController::class, 'getData'])->name('getData');
        Route::get('/create', [NewManagementController::class, 'create'])->name('create');
        Route::post('/create', [NewManagementController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [NewManagementController::class, 'edit'])->name('edit');
        Route::post('/upload-image', [NewManagementController::class, 'uploadGambar'])->name('uploadImage');
        Route::post('/update/{id}', [NewManagementController::class, 'update'])->name('update');
        Route::get('/lihat/{id}', [NewManagementController::class, 'show'])->name('show');
        Route::get('/delete/{id}', [NewManagementController::class, 'destroy'])->name('destroy');
    });


    Route::group(['prefix' => 'branchs-management', 'as' => 'branch-manager.'], function () {
        Route::get('/', [BranchManagementController::class, 'index'])->name('index');
        Route::get('/get-data', [BranchManagementController::class, 'getData'])->name('getData');
        Route::get('/tambah', [BranchManagementController::class, 'create'])->name('tambah');

        Route::post('/tambah', [BranchManagementController::class, 'store'])->name('save');
        Route::get('/lihat/{id}', [BranchManagementController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [BranchManagementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BranchManagementController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [BranchManagementController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'regions-of-management', 'as' => 'region-manager.'], function () {
        Route::get('/', [RegionOfManagementController::class, 'index'])->name('index');
        Route::get('/tambah', [RegionOfManagementController::class, 'create'])->name('create');
        Route::post('/tambah', [RegionOfManagementController::class, 'store'])->name('save');
        Route::get('/get-data', [RegionOfManagementController::class, 'getData'])->name('getData');
        Route::get('/get-data-kota/{id}', [RegionOfManagementController::class, 'getDataKota'])->name('getDataKota');
        Route::get('/lihat/{id}', [RegionOfManagementController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [RegionOfManagementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [RegionOfManagementController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [RegionOfManagementController::class, 'destroy'])->name('delete');
    });

    Route::get('/notif', [NotifController::class, 'index'])->name('notif.index');
    Route::get('/notif/get-data', [NotifController::class, 'datatable'])->name('notif.datatable');
    Route::post('/notif/read', [NotifController::class, 'read'])->name('notif.read');

    Route::group(['prefix' => 'customers-management', 'as' => 'customer-manager.'], function () {
        Route::get('/', [CustomerManagementController::class, 'index'])->name('index');
        Route::get('/tambah', [customerManagementController::class, 'create'])->name('create');
        Route::post('/tambah', [CustomerManagementController::class, 'store'])->name('save');
        Route::get('/lihat/{id}', [CustomerManagementController::class, 'show'])->name('show');
        Route::get('/get-data', [CustomerManagementController::class, 'getData'])->name('getData');
        Route::get('/edit/{id}', [CustomerManagementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CustomerManagementController::class, 'update'])->name('update');
        Route::post('/report/pdf', [CustomerManagementController::class, 'cetakPdf'])->name('cetakPDF');
        Route::post('/report/excel', [CustomerManagementController::class, 'reportExcel'])->name('excel');
        Route::POST('/delete', [CustomerManagementController::class, 'destroy'])->name('destroy');
        Route::get('/get-data-kota/{id}', [CustomerManagementController::class, 'getDataKota'])->name('getDataKota');
        Route::post('/submit', [CustomerManagementController::class, 'submit'])->name('submit');
        Route::post('/get-log', [CustomerManagementController::class, 'getLogEdit'])->name('get_log');
        Route::get('/get-login-customer', [CustomerManagementController::class, 'getLogCustomer'])->name('get_log_customer');
        Route::post('/get-log-detail', [CustomerManagementController::class, 'getLogDetail'])->name('get_log_detail');
        Route::post('/approve', [CustomerManagementController::class, 'approve'])->name('approve');
        Route::post('/reset-password', [CustomerManagementController::class, 'resetPassword'])->name('reset-password');
        Route::post('/submit-delete', [CustomerManagementController::class, 'submitDelete'])->name('submit_delete');


        Route::group(['prefix' => 'business-management', 'as' => 'business-manager.'], function () {
            Route::get('/get-data-usaha/{id}', [BusinessController::class, 'getData'])->name('getDataUsaha');
            Route::post('/tambah-usaha', [BusinessController::class, 'store'])->name('saveUsaha');
            Route::get('/edit/{id}', [BusinessController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BusinessController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BusinessController::class, 'destroy'])->name('delete');
        });
    });


    Route::group(['prefix' => 'cities-management', 'as' => 'city-manager.'], function () {
        Route::get('/', [CityManagementController::class, 'index'])->name('index');
        Route::get('/get-data', [CityManagementController::class, 'getData'])->name('getData');
        Route::post('/tambah', [CityManagementController::class, 'store'])->name('save');
        Route::get('/edit/{id}', [CityManagementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [cityManagementController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CityManagementController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'provincies-management', 'as' => 'province-manager.'], function () {
        Route::get('/', [ProvinceManagementController::class, 'index'])->name('index');
        Route::get('/get-data', [ProvinceManagementController::class, 'getData'])->name('getData');
        Route::get('/get-data-kota/{id}', [ProvinceManagementController::class, 'getDataKota'])->name('getDataKota');
        Route::post('/tambah', [ProvinceManagementController::class, 'store'])->name('save');
        Route::get('/edit/{id}', [ProvinceManagementController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProvinceManagementController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ProvinceManagementController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'categories-product', 'as' => 'category-manager.'], function () {
        Route::get('/', [CategoryProductController::class, 'index'])->name('index');
        Route::get('/get-data', [CategoryProductController::class, 'getData'])->name('getData');
        Route::get('/lihat/{id}', [CategoryProductController::class, 'show'])->name('show');
        Route::post('/tambah', [CategoryProductController::class, 'store'])->name('save');
        Route::get('/edit/{id}', [CategoryProductController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CategoryProductController::class, 'update'])->name('update');
        Route::post('/icons', [CategoryProductController::class, 'showIconGallery'])->name('icons');
        Route::get('/delete/{id}', [CategoryProductController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('jade.role.index');
        Route::get('/{id}/detail', [RoleController::class, 'detail'])->name('jade.role.detail');
        Route::post('/save', [RoleController::class, 'save'])->name('jade.role.save');
        Route::get('/datatables', [RoleController::class, 'datatables'])->name('jade.role.datatables');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('/customer', [ReportController::class, 'customer'])->name('report.customer');
        Route::get('/customer-pdf', [ReportController::class, 'printPdf'])->name('report.customer.pdf');
        Route::get('/customer-excel', [ReportController::class, 'printExcel'])->name('report.customer.excel');
        Route::get('/customer-preview', [ReportController::class, 'printPreview'])->name('report.customer.preview');
        Route::get('/customer-datables', [ReportController::class, 'customerDataTables'])->name('report.customer.getData');
        // Route::get('/{id}/detail', [RoleController::class, 'detail'])->name('jade.role.detail');
        // Route::post('/save', [RoleController::class, 'save'])->name('jade.role.save');

        // report DWH
        Route::group(['prefix' => 'dwh'], function () {
            Route::get('/volume-perjanjian', [ReportDWHController::class, 'volumePenjaminan'])->name('dwh.volume.penjaminan');
            Route::get('/volume-perjanjian-pdf', [ReportDWHController::class, 'getVolumePenjaminanPdf'])->name('dwh.volume.penjaminan.pdf');
            Route::get('/volume-perjanjian-excel', [ReportDWHController::class, 'getVolumePenjaminanExcel'])->name('dwh.volume.penjaminan.excel');
            Route::post('/volume-perjanjian/data', [ReportDWHController::class, 'getVolumePenjaminan'])->name('dwh.volumepenjaminan.getData');
            Route::get('/service-spd', [ReportDWHController::class, 'serviceSPD'])->name('dwh.servicespd');
            Route::get('/service-ijp', [ReportDWHController::class, 'serviceIJP'])->name('dwh.serviceijp');
            Route::get('/service-ijp-pdf', [ReportDWHController::class, 'serviceIJPPdf'])->name('dwh.serviceijp.pdf');
            Route::get('/service-ijp-excel', [ReportDWHController::class, 'serviceIJPExcel'])->name('dwh.serviceijp.excel');
            Route::post('/service-ijp/data', [ReportDWHController::class, 'getServiceIJP'])->name('dwh.serviceijp.getData');
            Route::get('/service-kld', [ReportDWHController::class, 'serviceKLD'])->name('dwh.servicekld');
            Route::post('/service-kld/data', [ReportDWHController::class, 'getServiceKLD'])->name('dwh.servicekld.getData');
            Route::get('/service-pdr-008', [ReportDWHController::class, 'servicePDR008'])->name('dwh.servicepdr008');
            Route::post('/service-pdr-008/data', [ReportDWHController::class, 'getServicePDR008'])->name('dwh.servicepdr008.getData');
            Route::get('/service-pr-001', [ReportDWHController::class, 'servicePR001'])->name('dwh.servicepr001');
            Route::post('/service-pr-001/data', [ReportDWHController::class, 'getServicePR001'])->name('dwh.servicepr001.getData');
            Route::get('/service-pr-004', [ReportDWHController::class, 'servicePR004'])->name('dwh.servicepr004');
            Route::post('/service-pr-004/data', [ReportDWHController::class, 'getServicePR004'])->name('dwh.servicepr004.getData');
            Route::get('/service-sbr-002', [ReportDWHController::class, 'serviceSBR002'])->name('dwh.servicesbr002');
            Route::post('/service-sbr-002/data', [ReportDWHController::class, 'getServiceSBR002'])->name('dwh.servicesbr002.getData');
        });
    });


    Route::get('/smtp', [SmtpController::class,'index'])->name('smtp.index');
    Route::post('/smtp/update', [SmtpController::class, 'update'])->name('smtp.update');

    Route::get('/audit-trail', [AuditTrailController::class,'index'])->name('audit-trail.index');
    Route::post('/audit-trail/datatables', [AuditTrailController::class,'datatables'])->name('audit-trail.datatable');
    Route::get('/audit-trail/show/{id}', [AuditTrailController::class,'show'])->name('audit-trail.show');

    Route::get('/chat', [ChattingManagementController::class, 'index'])->name('chat');
    Route::post('/conversations', [ChattingManagementController::class, 'createConversation'])->name('conversation.create');
    Route::post('/messages', [ChattingManagementController::class, 'sendMessage'])->name('sendMessage');
    Route::get('/conversations/{id}/messages', [ChattingManagementController::class, 'getMessages'])->name('conversation.message');
    Route::get('/conversations', [ChattingManagementController::class, 'getConversations'])->name('conversation');

    Route::post('/chat/chat-read', [ChattingManagementController::class, 'readMessage'])->name('chat-read');
    Route::post('/chat/chat-reply', [ChattingManagementController::class, 'chatReply'])->name('chat-reply');
    Route::post('/chat/chat-close', [ChattingManagementController::class, 'chatClose'])->name('chat-close');
    Route::get('/chat/unread-conversation', [ChattingManagementController::class, 'unreadConversation'])->name('chat-unread');
    Route::get('/chat/unread-message', [ChattingManagementController::class, 'unreadMessage'])->name('chat-unread-Message');
    Route::post('/chat/upload-file', [ChattingManagementController::class, 'uploadFile'])->name('upload-file');
    // Route::post('/chat/chat-close', [ChattingManagementController::class, 'chatClose'])->name('chat-close');
    Route::post('/chat/check-receive', [ChattingManagementController::class, 'checkReceive'])->name('check-receive');
    Route::get('/fetch-messages', [ChattingManagementController::class, 'fetchMessages']);



    Route::get('/table-create', [DatabaseController::class, 'index'])->name('create-table');
    Route::post('/table-create', [DatabaseController::class, 'createTable'])->name('table.store');
    Route::get('/table-get', [DatabaseController::class, 'getAllTables'])->name('table.get');
    Route::get('/table-show/{tableName}', [DatabaseController::class, 'getTableDetails'])->name('table.detail');
});
