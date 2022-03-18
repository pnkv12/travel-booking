<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ToursController;
use Illuminate\Support\Facades\Route;

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

Route::get('/signup', [UserController::class, 'signupAction'])->name('user.signup');
Route::post('/confirmSignUp', [UserController::class, 'confirmSignUpAction'])->name('user.confirmSignUp');

Route::get('/login', [UserController::class, 'loginAction'])->name('user.login');
Route::post('/postLogin', [UserController::class, 'postLoginAction'])->name('user.postLogin');

Route::group(
    [
        'middleware' => ['web', 'auth']
    ],
    function () {
        Route::get('/index',  [UserController::class, 'indexAction'])->name('user.index');
        Route::get('/logout', [UserController::class, 'logoutAction'])->name('user.logout');

        Route::prefix('admin')->group(function () {
            Route::get('/', [UserController::class, 'viewAction'])->name('admin.list');
            Route::get('profile/{id}', [UserController::class, 'profileAction'])->name('admin.profile');
            Route::get('edit/{id}', [UserController::class, 'editAdAction'])->name('admin.edit');
            Route::post('update', [UserController::class, 'updateAction'])->name('admin.update');
            Route::get('changepassword/{id}', [UserController::class, 'changePWAction'])->name('admin.changepw');
            Route::post('confirmchange', [UserController::class, 'confirmPWAction'])->name('admin.confirmchange');
            Route::delete('delete/{id}', [UserController::class, 'deleteUserAction'])->name('admin.delete');
        });
        Route::prefix('news')->group(function () {
            Route::get('/', [NewsController::class, 'newsListAction'])->name('news.list');
            Route::get('add', [NewsController::class, 'addNewsAction'])->name('news.add');
            Route::post('store', [NewsController::class, 'storeNewsAction'])->name('news.store');
            Route::get('details/{id}', [NewsController::class, 'viewNewsAction'])->name('news.details');
            Route::get('edit/{id}', [NewsController::class, 'editNewsAction'])->name('news.edit');
            Route::post('update', [NewsController::class, 'updateNewsAction'])->name('news.update');
            Route::delete('delete/{id}', [NewsController::class, 'deleteNewsAction'])->name('news.delete');
        });

        Route::prefix('tours')->group(function () {
            Route::get('/', [ToursController::class, 'tourListAction'])->name('tours.list');
            Route::get('add', [ToursController::class, 'addTourAction'])->name('tours.add');
            Route::post('store', [ToursController::class, 'storeTourAction'])->name('tours.store');
            Route::get('details/{id}', [ToursController::class, 'viewTourAction'])->name('tours.details');
            Route::get('edit/{id}', [ToursController::class, 'editTourAction'])->name('tours.edit');
            Route::post('update', [ToursController::class, 'updateTourAction'])->name('tours.update');
            Route::delete('delete/{id}', [ToursController::class, 'deleteTourAction'])->name('tours.delete');
        });

        Route::prefix('ticket')->group(function () {
            Route::get('/', [BookingController::class, 'listAction'])->name('ticket.list');
            Route::get('details/{id}', [BookingController::class, 'viewTicketAction'])->name('ticket.details');
            Route::post('update', [BookingController::class, 'updateStateAction'])->name('ticket.update');
        });
    }
);
