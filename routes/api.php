<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\GarageRegisterController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\client\AboutController;
use App\Http\Controllers\client\FavouriteGarageController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ProfileController;
use App\Http\Controllers\garage\OrderController;
use App\Http\Controllers\garage\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:sanctum']
],
function () {
    Route::group([
        'prefix' => 'brand',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::get('/', [BrandController::class, 'getBrand']);
        Route::post('/', [BrandController::class, 'createBrand']);
        Route::put('/{id}', [BrandController::class, 'updateBrand']);
        Route::get('/{id}', [BrandController::class, 'deleteBrand']);
    });
    Route::group([
        'prefix' => 'service',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::post('/', [ServiceController::class, 'registerService']);
        Route::put('/{id}', [ServiceController::class, 'editService']);
        Route::get('/{id}', [ServiceController::class, 'deleteService']);
    });
    Route::get('/', [UserController::class, 'all']);
    
});

Route::group([
    'prefix' => 'client',
], function () {
    Route::group([
        'prefix' => 'profile',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::post('/update', [ProfileController::class, 'update']);
        Route::post('/create-car', [ProfileController::class, 'createCar']);
        Route::post('/update-car/{id}', [ProfileController::class, 'updateCar']);
        Route::get('/delete-car/{id}', [ProfileController::class, 'deleteCar']);
        Route::get('/get-order', [ProfileController::class, 'getOrder']);
    });
    Route::group([
        'prefix' => 'favourite-garage',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::post('/', [FavouriteGarageController::class, 'registerFavouriteGarage']);
        Route::get('/', [FavouriteGarageController::class, 'getFavouriteGarageByUserId']);
    });
    Route::group([
        'prefix' => 'about',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::get('/get-all-service', [AboutController::class, 'getAllService']);
        Route::get('/get-all-brand', [AboutController::class, 'getAllBrand']);
    });
    Route::group([
        'prefix' => 'home'
    ], function () {
        Route::get('/get-all-garage', [HomeController::class, 'getAllGarage']);
    });
});

Route::group([
    'prefix' => 'garage',
    'middleware' => ['auth:sanctum']
], function () {
    Route::group([
        'prefix' => 'staff',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::get('/{idGarage}', [StaffController::class, 'getStaff']);
        Route::post('/', [StaffController::class, 'registerStaff']);
        Route::put('/{id}', [StaffController::class, 'editStaff']);
        Route::get('/delete/{id}', [StaffController::class, 'deleteStaff']);
    });
    Route::group([
        'prefix' => 'order',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::get('/get-order', [OrderController::class, 'showOrder']);
    });
    Route::get('/get-garage-register', [GarageRegisterController::class, 'getAllGarageRegister']);
    Route::put('/update-status/{id}', [GarageRegisterController::class, 'updateGarageStatus']);
});


Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('/login', [AuthenController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/logout', [AuthenController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/repass', [AuthenController::class, 'repass'])->middleware('auth:sanctum');
});