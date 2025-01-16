<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\API\AuthController as APIAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\MasterController;
use App\Http\Controllers\api\CategoryProductController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\NewsController;
use App\Http\Controllers\api\ProvinceController;
use App\Http\Controllers\api\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/test-email', [MasterController::class, 'testEmail']);

    Route::get('/genpass', 'api\AuthController@genpass')->name('api.genpass');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/registration', [AuthController::class, 'registration'])->name('api.registration');


    Route::get('/branch', [MasterController::class, 'branch'])->name('branch');
    Route::get('/region', [MasterController::class, 'region'])->name('region');

    Route::get('/provinces', [ProvinceController::class, 'getProvinces'])->name('api.provinces');

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyOTPForgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth.mobile')->group(function () {
        Route::delete('/logout', [AuthController::class, 'logout']);
        
        Route::get('/profile', [AuthController::class, 'getProfile'])->name('api.profile');
        Route::post('/profile', [AuthController::class, 'updateProfile'])->name('api.profile.update');

        Route::get('/categories', [CategoryProductController::class, 'getCategories']);
        Route::get('/categories/{id}', [CategoryProductController::class, 'getCategory']);
    
        Route::get('/products/{id}', [ProductController::class, 'getProduct']);
    
        Route::get('/news', [NewsController::class, 'getNews']);
        Route::get('/news/{id}', [NewsController::class, 'getNewsDetail']);

        Route::get('/messages', [MessageController::class, 'getMessages']);
        Route::post('/messages', [MessageController::class, 'sendMessage']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
