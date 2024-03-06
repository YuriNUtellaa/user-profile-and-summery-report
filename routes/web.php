<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SlotsController;




// FOR WEBSITE INTERFACE ////////////////////////////////////

    Route::get('/', [SlotsController::class, 'index'])->name('/');
    Route::get('/home', [SlotsController::class, 'index'])->name('home');
    Route::get('/slots', [SlotsController::class, 'slot'])->name('slots');

// FOR ADMIN INTERFACE ////////////////////////////////////

    Route::get('/register-admin', [AdminController::class, 'showRegistrationForm'])->name('register-admin');
    Route::post('/register-admin', [AdminController::class, 'register']);

    Route::get('/login-admin', [AdminController::class, 'showLoginForm'])->name('login-admin');
    Route::post('/login-admin', [AdminController::class, 'login']);

    Route::get('/slots-control-admin', [AdminController::class, 'showAdminSlot'])->name('slots-control-admin');
    Route::post('/logout-admin', [AdminController::class, 'logout'])->name('logout-admin');

    // SLOT CONTROL FOR IRREGULAR USER

        //RENT
            Route::get('/rent-admin/{slot}', [SlotsController::class, 'showRentAdminForm'])->name('rentAdmin');
            Route::post('/confirm-rent-admin', [SlotsController::class, 'confirmRentAdmin'])->name('confirmRentAdmin');
            Route::put('/end-renting-admin/{slot}', [SlotsController::class, 'endRentingAdmin'])->name('end-renting-admin');

        // RESERVE
            Route::get('/reserve-admin/{slot}', [SlotsController::class, 'showReserveAdminForm'])->name('reserveAdmin');
            Route::post('/confirm-reserve-admin', [SlotsController::class, 'confirmReserveAdmin'])->name('confirm-reserve-admin');


    // RENT & RESERVATIONS

        Route::middleware('auth:admin')->group(function () {
            // Route for showing the history page
            Route::get('/history-admin', [AdminController::class, 'showAdminHistory'])->name('history-admin');

            // Routes for updating and deleting slot rentals
            Route::get('/update-slot-rental/{id}', [AdminController::class, 'updateSlotRental'])->name('update-slot-rental');
            Route::delete('/delete-slot-rental/{id}', [AdminController::class, 'deleteSlotRental'])->name('delete-slot-rental');

            // Routes for updating sa rent and reservation
            Route::put('/update-slot-rental/{id}', [AdminController::class, 'updateSlotRental'])->name('update-slot-rental');
            Route::put('/update-reservation/{id}', [AdminController::class, 'updateReservation'])->name('update-reservation');

            // DELETE FUNCTION PARA SA RENT AND RESERVATION
            Route::delete('/delete-slot-rental/{id}', [AdminController::class, 'deleteSlotRental'])->name('delete-slot-rental');
            Route::delete('/delete-reservation/{id}', [AdminController::class, 'deleteReservation'])->name('delete-reservation');
        });

    // USERMANAGEMENT

        Route::put('/user-management/{user}', [AdminController::class, 'updateUser'])->name('admin.update-user');
        Route::delete('/user-management/{user}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');

        Route::middleware(['auth:admin'])->group(function () {
            Route::get('/user-management', [AdminController::class, 'showUserManagement'])->name('admin.user-management');
        });



// FOR USER INTERFACE ////////////////////////////////////

    Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', [UserController::class, 'showLoginPage'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // RENT

        Route::get('/rent/{slot}', [SlotsController::class, 'showRentForm'])->name('rent');
        Route::post('/confirm-rent', [SlotsController::class, 'confirmRent'])->name('confirm-rent');

        Route::put('/end-renting/{slot}', [SlotsController::class, 'endRent'])->name('end-renting');


    // RESERVE

        Route::post('/reserve/{slot}', [SlotsController::class, 'showReserveForm'])->name('reserve');
        Route::post('/confirm-reserve', [SlotsController::class, 'confirmReserve'])->name('confirm-reserve');

//summery

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/summary', [AdminController::class, 'showSummary']);
    Route::get('/admin/generate-summary-report', [AdminController::class, 'generateSummaryReportPDF'])
         ->name('admin.generate-summary-report');


});
 //userprofile
 Route::get('/userprofile', [UserController::class, 'showuserprofile']);
 Route::get('/userprofile', [UserController::class, 'showuserprofile'])->name('userprofile');
 Route::put('/userprofile', [UserController::class, 'update'])->name('user.update');
 Route::put('/userprofile/deactivate', [UserController::class, 'deactivate'])->name('user.deactivate');
