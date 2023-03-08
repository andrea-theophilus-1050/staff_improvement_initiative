<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\QALeaders\QALeadersController;
use App\Http\Controllers\QACoordinators\QACoordinatorsController;
use App\Http\Controllers\Staff\StaffController;

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
    return redirect()->route('login');
});

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', [AuthController::class, 'login_action'])->name('login.action');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['userRole:1'])->group(function () {
        Route::group(['prefix' => 'administrator'], function () {
            Route::get('dashboard', [AdminController::class, 'index'])->name('admin.index');
            Route::get('account-management', [AdminController::class, 'account_management'])->name('admin.account.management');
        });
    });

    Route::middleware(['userRole:2'])->group(function () {
        Route::group(['prefix' => 'quality-assurance-manager'], function () {
            Route::get('dashboard', [QALeadersController::class, 'index'])->name('qa-leaders.index');
        });
    });

    Route::middleware(['userRole:3'])->group(function () {
        Route::group(['prefix' => 'quality-assurance-coordinators'], function () {
            Route::get('dashboard', [QACoordinatorsController::class, 'index'])->name('qa-coordinators.index');
        });
    });

    Route::middleware(['userRole:4'])->group(function () {
        Route::group(['prefix' => 'staff'], function () {
            Route::get('dashboard', [StaffController::class, 'index'])->name('staff.index');
        });
    });
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('test', function () {
//     return view('index');
// });