<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
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

        Route::prefix('admin')->group(function() {
            Route::get('/list', [UserController::class, 'viewAction'])->name('admin.list'); 
        });
        Route::prefix('news')->group(function() {
            Route::get('/list', [NewsController::class, 'newsListAction'])->name('news.list');
            Route::get('/add',  [NewsController::class, 'addAction'])->name('news.add');
            Route::post('/store',  [NewsController::class, 'storeAction'])->name('news.store');
        });

    }
);

// Route::group(
//     [
//         'middleware' => ['web', 'auth']
//     ],
//     function () {

//         Route::prefix('admin')->group(function() {
//             Route::get('/', 'BookController@indexAction')->name('admin.index');
//             Route::get('add','BookController@addAction')->name('admin.add');
//             Route::post('store','BookController@storeBookAction')->admin('book.store');
//             Route::get('edit/{id}','BookController@editAction')->admin('book.edit');
//             Route::get('update/{id}','BookController@updateAction')->name('admin.update');
//         });
//     }
// );

