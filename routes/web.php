<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::middleware(['auth', 'verified'])->group(function () {
    if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
    }

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/client/{id}', [DashboardController::class, 'client'])->name('dashboard.client');
    Route::get('/dashboard/client', [DashboardController::class, 'client'])->name('dashboard.client');
    Route::get('/dashboard/orders', [DashboardController::class, 'getOrderData'])->name('dashboard.orders');
    Route::post('/dashboard/orders', [DashboardController::class, 'getOrderData'])->name('dashboard.orders');
    Route::get('/dashboard/purchases', [DashboardController::class, 'purchases'])->name('dashboard.purchases');
    Route::get('/dashboard/userProfits', [DashboardController::class, 'userProfits'])->name('dashboard.userProfits');
    Route::get('/dashboard/createProduct', [DashboardController::class, 'showProductForm'])->name('dashboard.createProduct');
    Route::post('/dashboard/createProduct', [DashboardController::class, 'createProduct'])->name('dashboard.createProduct.post');
    Route::get('/dashboard/monthlyReports', [DashboardController::class, 'showMonthlyReports'])->name('dashboard.monthlyReports');
    Route::post('/dashboard/shippingFee', [DashboardController::class, 'shippingFee'])->name('dashboard.monthlyReports.post');
    Route::get('/dashboard/addPost', [DashboardController::class, 'showAddPost'])->name('dashboard.addPost');
    Route::post('/dashboard/addPost', [DashboardController::class, 'addPost'])->name('dashboard.addPost.post');
    Route::get('/dashboard/editPost/{id}', [DashboardController::class, 'showEditPost'])->name('dashboard.editPost');
    Route::post('/dashboard/editPost/{id}', [DashboardController::class, 'editPost'])->name('dashboard.editPost.post');
    Route::delete('/dashboard/deletePost/{id}', [DashboardController::class, 'deletePost'])->name('dashboard.deletePost');
    Route::get('/dashboard/allPosts', [DashboardController::class, 'allPosts'])->name('dashboard.allPosts');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::post('/user-management/users/store', [UserManagementController::class, 'store'])->name('user-management.users.store');
        Route::get('/user-management/getusers/{id}', [UserManagementController::class, 'getUser'])->name('user-management.users.getUser');
        Route::post('/user-management/updateUser/{id}', [UserManagementController::class, 'update']);
        Route::post('/user-management/users/checkEmail', [UserManagementController::class, 'checkEmail'])->name('users.checkEmail');
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
