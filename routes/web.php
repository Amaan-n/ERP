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
    Route::post('reset-password', 'HomeController@resetPassword')->name('reset_password');
   

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
         //=======Activity Logs Route======= //
        Route::any('/activity_logs', 'HomeController@activity_logs')->name('activity_logs');

        Route::resource('groups', 'GroupsController');
        Route::resource('users', 'UsersController');

        Route::group(['prefix' => 'configurations'], function () {
            Route::get('', 'ConfigurationsController@index')->name('configurations');
            Route::post('update', 'ConfigurationsController@update')->name('configurations.update');
        });
    });

    // =============== ROUTES FOR HUMAN RESOURCES =============== //
    Route::group(['prefix' => 'hrms'], function () {
        Route::get('home', 'HomeController@humanResourceManagementIndex')->name('hrms.home');

        //////=========Calendar===////////
        Route::any('/calendar', 'CalendarController@show_calendar')->name('calendar.show');

        //Holidays Routes
        Route::post('/add_holiday', 'CalendarController@add_holiday')->name('add.holiday');
        Route::post('/update_holiday', 'CalendarController@edit_holiday')->name('edit.holiday');
        Route::delete('/delete_holiday', 'CalendarController@delete_holiday')->name('delete.holiday');

        //Attendance Routes
        Route::post('add_attendance', "CalendarController@add_attendance")->name('add.attendance');
        Route::post('/update_attendance', 'CalendarController@edit_attendance')->name('edit.attendance');
        Route::delete('/delete_attendance', 'CalendarController@delete_attendance')->name('delete.attendance');

        Route::get('asset_model/parameters', 'AssetModelsController@getParametersByAssetModel')->name('asset_model.parameters');
        Route::get('mappings/create', 'MappingsController@create')->name('tags.mapping');
        Route::post('mappings/store', 'MappingsController@store')->name('mappings.store');

        Route::group(['prefix' => 'assets/allocation'], function () {
            Route::get('', 'AllocationsController@index')->name('assets.allocation');
            Route::post('', 'AllocationsController@store')->name('assets.allocation.store');
            Route::get('items', 'AllocationsController@getAllocatedItemsByUser')->name('assets.allocation.items');
        });

        Route::resource('employees', 'EmployeesController');
        Route::resource('manufacturers', 'ManufacturersController');
        Route::resource('suppliers', 'SuppliersController');
        Route::resource('departments', 'DepartmentsController');
        Route::resource('asset_models', 'AssetModelsController');
        Route::resource('field_groups', 'FieldGroupsController');
        Route::resource('fields', 'FieldsController');
        Route::resource('asset_categories', 'AssetCategoriesController');
        Route::resource('assets', 'AssetsController');
        Route::resource('tags', 'TagsController')->only(['index', 'create', 'store', 'show']);
    });

    // =============== ROUTES FOR WAREHOUSES MANAGEMENT =============== //
    Route::group(['prefix' => 'orders'], function () {
        Route::get('', function () {
            return redirect()->route('orders.home');
        });

        Route::get('home', 'HomeController@ordersManagementIndex')->name('orders.home');

        Route::resource('customers', 'CustomersController');
        Route::resource('locations', 'LocationsController');
        Route::resource('measuring_units', 'MeasuringUnitsController');
        Route::resource('product_categories', 'ProductCategoriesController');
        Route::resource('products', 'ProductsController');
    });

    // =============== ROUTES FOR POS =============== //
    Route::group(['prefix' => 'pos'], function () {
        Route::get('customer_by_phone', 'CustomersController@getCustomerByPhone')->name('pos.customer_by_phone');
        Route::get('items', 'PosController@getItems')->name('pos.items');

        Route::get('create', 'PosController@create')->name('pos.create');
        Route::get('', 'PosController@index')->name('pos.index');
        Route::get('ajax', 'PosController@getBookings')->name('pos.get_bookings');
        Route::post('store', 'PosController@store')->name('pos.store');
        Route::get('{booking_slug}', 'PosController@show')->name('pos.show');
        Route::get('print/invoice', 'PosController@printInvoice')->name('pos.print_invoice');
    });
});
