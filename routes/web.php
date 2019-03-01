<?php

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

Auth::routes();

// Frontend Booking Routes
Route::get('/', 'Frontend\BookingController@index')->name('booking.index');
Route::post('/booking/store', 'Frontend\BookingController@store')->name('booking.store');
Route::any('/tickets/download', 'Frontend\BookingController@downloadTickets')->name('booking.tickets.download');

// Admin Routes
Route::get('/admin', 'Admin\AdminController@index')->name('admin.index');
Route::get('/admin/report', 'Admin\AdminController@report')->name('admin.report');

