<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['verify' => false, 'register' => false]);

Route::get('401', 'HomeController@error401')->name('401');
Route::get('404', 'HomeController@error404')->name('404');
Route::get('lock', 'HomeController@authLock')->name('auth.lock');
Route::post('unlock', 'HomeController@authUnLock')->name('auth.unlock');
Route::post('validate/unique', 'HomeController@validateUnique')->name('validate.unique');

Route::group(['middleware' => ['auth', 'verified', 'check.access']], function () {

    Route::get('profile', 'HomeController@profile')->name('profile');
    Route::get('change-password', 'HomeController@changePassword')->name('change_password');
    Route::post('update-password', 'HomeController@updatePassword')->name('update_password');
    Route::get('remove/file', 'HomeController@removeFile')->name('remove.file');
    Route::get('state/update', 'HomeController@updateState')->name('state.update');

    Route::post('notes', 'NotesController@store')->name('notes.store');
    Route::get('notes/{id?}', 'NotesController@destroy')->name('notes.destroy');

    Route::group(['prefix' => 'attachments'], function () {
        Route::get('{module_name}/{reference_id}', 'AttachmentsController@attachments')->name('attachments');
        Route::any('{module_name?}/{reference_id?}/upload', 'AttachmentsController@upload')->name('attachments.upload');
    });

    Route::group(['prefix' => 'imports'], function () {
        Route::get('{type?}', 'ImportsController@import')->name('imports');
        Route::any('{type?}/parse', 'ImportsController@parse')->name('imports.parse');
    });

    Route::group(['prefix' => 'exports'], function () {
        Route::get('{type?}/{id?}', 'ExportsController@export')->name('exports');
    });

    Route::get('home', function () {
        return redirect()->route('home');
    });

    // =============== ROUTES FOR ADMIN USERS =============== //
    Route::group(['prefix' => 'admin'], function () {
        Route::get('home', 'HomeController@index')->name('home');

        Route::resource('groups', 'GroupsController');
        Route::resource('users', 'UsersController');

        Route::group(['prefix' => 'configurations'], function () {
            Route::get('', 'ConfigurationsController@index')->name('configurations');
            Route::post('update', 'ConfigurationsController@update')->name('configurations.update');
        });
    });

    // =============== ROUTES FOR ASSETS MANAGEMENT =============== //
    Route::group(['prefix' => 'assets_management'], function () {
        Route::get('home', 'HomeController@assetsManagementIndex')->name('assets_management.home');
    });

    // =============== ROUTES FOR WAREHOUSES MANAGEMENT =============== //
    Route::group(['prefix' => 'warehouses_management'], function () {
        Route::get('home', 'HomeController@warehousesManagementIndex')->name('warehouses_management.home');
    });
});
