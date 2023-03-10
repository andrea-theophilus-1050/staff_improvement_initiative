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
            Route::get('department-management', [AdminController::class, 'department_management'])->name('admin.department.management');
            Route::post('department-management/create', [AdminController::class, 'createDepartment'])->name('admin.department.store');
            Route::post('department-management/update/{id}', [AdminController::class, 'updateDepartment'])->name('admin.department.update');
            Route::post('department-management/delete/{id}', [AdminController::class, 'deleteDepartment'])->name('admin.department.delete');

            Route::get('account-management', [AdminController::class, 'account_management'])->name('admin.account.management');
            Route::post('account-management/create', [AdminController::class, 'storeAccount'])->name('account.store');
            Route::post('account-management/update/{id}', [AdminController::class, 'updateAccount'])->name('account.update');
            Route::post('account-management/delete/{id}', [AdminController::class, 'deleteAccount'])->name('account.delete');
        });
    });

    Route::middleware(['userRole:2', 'passwordChanged'])->group(function () {
        Route::group(['prefix' => 'quality-assurance-manager'], function () {
            Route::get('dashboard', [QALeadersController::class, 'index'])->name('qa-leaders.index');
        });
    });

    Route::middleware(['userRole:3', 'passwordChanged'])->group(function () {
        Route::group(['prefix' => 'quality-assurance-coordinators'], function () {
            Route::get('dashboard', [QACoordinatorsController::class, 'index'])->name('qa-coordinators.index');
        });
    });

    Route::middleware(['userRole:4', 'passwordChanged'])->group(function () {
        Route::group(['prefix' => 'staff'], function () {
            Route::get('index', [StaffController::class, 'index'])->name('staff.index');
            Route::get('topics', [StaffController::class, 'topics'])->name('staff.topics');
            Route::get('posts', [StaffController::class, 'posts'])->name('staff.posts');
        });
    });

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('auth.change.password');
    Route::post('change-profile', [AuthController::class, 'changeProfile'])->name('auth.change.profile');
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('test', function () {
//     return view('index');
// });