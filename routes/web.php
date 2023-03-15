<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DownloadFileController;
use App\Http\Controllers\LikeDislikeController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\QALeaders\QALeadersController;
use App\Http\Controllers\QACoordinators\QACoordinatorsController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\TopIdeasController;

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
            Route::get('department-management', [AdminController::class, 'department_management'])->name('admin.department.management');
            Route::post('department-management/create', [AdminController::class, 'createDepartment'])->name('admin.department.store');
            Route::post('department-management/update/{id}', [AdminController::class, 'updateDepartment'])->name('admin.department.update');
            Route::post('department-management/delete/{id}', [AdminController::class, 'deleteDepartment'])->name('admin.department.delete');

            Route::get('account-management', [AdminController::class, 'account_management'])->name('admin.account.management');
            Route::post('account-management/create', [AdminController::class, 'storeAccount'])->name('account.store');
            Route::post('account-management/update/{id}', [AdminController::class, 'updateAccount'])->name('account.update');
            Route::post('account-management/delete/{id}', [AdminController::class, 'deleteAccount'])->name('account.delete');

            Route::get('topics-management', [AdminController::class, 'topics'])->name('admin.index');
            Route::post('topic-update-deadline/{id}', [AdminController::class, 'updateDeadline'])->name('topic.update.deadline');
        });
    });

    Route::middleware(['userRole:2', 'passwordChanged'])->group(function () {
        Route::group(['prefix' => 'quality-assurance-manager'], function () {
            Route::get('category-management', [QALeadersController::class, 'category'])->name('qa-leaders.category.management');
            Route::post('category-management/create', [QALeadersController::class, 'createCategory'])->name('qa-leaders.category.store');
            Route::post('category-management/update/{id}', [QALeadersController::class, 'updateCategory'])->name('qa-leaders.category.update');
            Route::post('category-management/delete/{id}', [QALeadersController::class, 'deleteCategory'])->name('qa-leaders.category.delete');

            Route::get('topics-management', [QALeadersController::class, 'topics'])->name('qa-leaders.topics.management');
            Route::post('topics-management/create', [QALeadersController::class, 'createTopics'])->name('qa-leaders.topics.store');
            Route::post('topics-management/update/{id}', [QALeadersController::class, 'updateTopics'])->name('qa-leaders.topics.update');

            Route::get('idea-posts/{id}', [QALeadersController::class, 'ideaPosts'])->name('qa-leaders.idea.posts');
            Route::get('download-all-files/{id}', [DownloadFileController::class, 'downloadAllFiles'])->name('qa-leaders.download.all.files');
            Route::get('exportCSV/{topicID}', [DownloadFileController::class, 'exportCSV'])->name('qa-leaders.export.csv');

            Route::get('test/{id}', [QALeadersController::class, 'top3'])->name('test.top.3');
        });
    });

    Route::middleware(['userRole:3', 'passwordChanged'])->group(function () {
        Route::group(['prefix' => 'quality-assurance-coordinators'], function () {
            Route::get('staff-management', [QACoordinatorsController::class, 'index'])->name('qa-coordinators.index');
            Route::get('topics', [QACoordinatorsController::class, 'topics'])->name('qa-coordinators.topics');
            Route::get('topics/idea-posts/{id}', [QACoordinatorsController::class, 'topicIdeaPosts'])->name('qa-coordinators.topics.idea.posts');
            Route::get('send-notification/{id}', [QACoordinatorsController::class, 'sendNotification'])->name('qa-coordinators.send.notify');
        });
    });

    Route::middleware(['userRole:4', 'passwordChanged'])->group(function () {
        Route::group(['prefix' => 'staff'], function () {
            Route::get('index', [StaffController::class, 'index'])->name('staff.index');
            Route::get('topics/idea-posts/{id}', [StaffController::class, 'topicIdeaPosts'])->name('staff.topics.idea.posts');
            Route::get('your-posts', [StaffController::class, 'ownPosts'])->name('staff.posts');

            Route::post('posts/create/{id}', [StaffController::class, 'createPost'])->name('staff.posts.submit.idea');
        });
    });

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('auth.change.password');
    Route::post('change-profile', [AuthController::class, 'changeProfile'])->name('auth.change.profile');

    Route::post('posts/comment/submit/{postID}', [LikeDislikeController::class, 'submitComment'])->name('staff.posts.comments.submit');
    Route::post('posts/like-dislike/{postID}/{status}', [LikeDislikeController::class, 'likeDislike'])->name('posts.like.dislike');

    Route::get('notification-handler/{type}/{url}/{notifyID}', [NotifyController::class, 'notificationHandlerTopic'])->name('notification.handler');
    Route::get('download-file/{id}', [DownloadFileController::class, 'downloadFile'])->name('download.idea.file');
    Route::get('list-of-top-ideas/{topicID}', [TopIdeasController::class, 'listOfTopIdeas'])->name('list.of.top-ideas');
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('test', function () {
//     return view('index');
// });