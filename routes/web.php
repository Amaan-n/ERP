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

        Route::get('create', 'PosController@create')->name('pos.create');
        Route::get('items', 'PosController@getItems')->name('pos.items');

        Route::get('', 'PosController@index')->name('pos.index');
        Route::get('ajax', 'PosController@getBookings')->name('pos.get_bookings');

        Route::post('update/payment_type', 'PosController@updatePaymentType')->name('pos.update_payment_type');
        Route::post('pos/update_status', 'PosController@updateBookingStatus')->name('pos.update_status');
        Route::get('calendar_booking_data', 'PosController@getCalendarBookingData')->name('calendar.booking_data');
        Route::post('store', 'PosController@store')->name('pos.store');
        Route::post('cancel', 'PosController@cancelBooking')->name('pos.cancel_booking');
        Route::post('receive/payment', 'PosController@receivePayment')->name('pos.receive.payment');
        Route::get('{booking_slug}', 'PosController@show')->name('pos.show');
        Route::get('print/invoice', 'PosController@printInvoice')->name('pos.print.invoice');
        Route::get('coupon/validate', 'PosController@validateCoupon')->name('coupon.validate');
        Route::get('voucher/validate', 'PosController@validateVoucher')->name('voucher.validate');
    });
});
