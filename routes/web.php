<?php

use App\Http\Controllers\Web\Admin\CommissionsController;
use App\Http\Controllers\Web\Admin\DepositController;
use App\Http\Controllers\Web\Admin\PerformanceBonusController;
use App\Http\Controllers\Web\Admin\WithdrawalController;
use App\Http\Controllers\Web\LocalizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
/*
    GET - Request resource
    POST - Create resource
    PUT - Update resource (All data)
    PATCH - Modify resource (Only changed data)
    DELETE - Delete resource
    OPTIONS - Ask server which verbs are allowed
*/


Route::namespace('Web')->middleware('jwt.set')->group(function () {
    Route::get('localization/{locale}',[LocalizationController::class, 'setLang']);



    //TODO: login page as default page
    Route::redirect('/', 'welcome');

    //TODO: without credential page (login, register)
    Route::controller(AuthController::class)->middleware('guest')->group(function () {

        Route::get('/welcome', 'getLogin')->name('welcome');
        Route::match(['get', 'post'],'/login', 'postLogin');

        Route::get('/register/{referral?}', 'getRegister')->name('register');
        Route::post('/register', 'postRegister');

        Route::get('/forgot-password', 'getForgotPassword')->name('password.request');
        Route::post('/forgot-password', 'postForgotPassword')->name('password.email');

        Route::get('/reset-password', 'getResetPassword')->name('password.reset');
        Route::post('/reset-password', 'postResetPassword')->name('password.update');
    });

    // TODO: if token is valid then only perform the action below
    Route::middleware('jwt.verify')->group(function () {
        Route::middleware('role.check:member')->prefix('member')->namespace('Member')->group(function () {
            Route::controller('UserController')->group(function () {
                Route::get('/welcome_page', 'welcome_page')->name('welcome_page');
                Route::get('/dashboard', 'dashboard')->name('member_dashboard');
                Route::match(['get', 'post'], '/change-password', 'changePassword')->name('member_change_password');
//                Route::post('/change-password', 'changePasswordSave');
                Route::get('/tree', 'tree');
                Route::match(['get', 'post'], '/tree', 'tree');
                Route::get('/profile', 'profile')->name('member_profile');
                Route::match(['get', 'post'], '/verification', 'verification')->name('member_verification');
                Route::match(['get', 'post'], '/downline_listing', 'downline_listing')->name('member_downline_listing');
                Route::get('/account/{id}', 'account');
                Route::post('/export-network', 'exportExcel');
                Route::post('/update-profile-pic', 'updateProfilePicture');
                Route::post('/leave-impersonate', 'leaveImpersonate')->name('leave_impersonate_user');
            });
            Route::controller('BrokersController')->group(function () {
                Route::get('/brokers', 'index');
            });
            Route::controller('CommissionController')->group(function () {
                Route::get('/commissions', 'index');
                Route::match(['get', 'post'], '/commissions', 'index')->name('commissions_listing');
                Route::match(['get', 'post'], '/network', 'network')->name('network_commissions_listing');
            });
            Route::controller('DepositController')->group(function () {
                Route::match(['get', 'post'], '/deposit/{id}', 'deposit')->name('deposits_listing');
                Route::match(['get', 'post'], '/funds', 'index2')->name('funds_listing');
                //temporarily for testing
                Route::post('/import-deposit', 'store');
                Route::post('/export-deposit', 'export');
            });
            Route::controller('WithdrawalController')->group(function () {
                Route::match(['get', 'post'], '/withdrawals', 'index')->name('withdrawals_listing');
                Route::post('/store-withdrawal', 'store');
            });
            Route::controller('PerformanceBonusController')->group(function () {
                Route::match(['get', 'post'], '/performance_bonus', 'listing')->name('member_performance_bonus');
            });
        });

        Route::middleware('role.check:Admin')->prefix('admin')->namespace('Admin')->group(function () {

            Route::controller('UserController')->group(function () {
                Route::get('/dashboard', 'dashboard')->name('admin_dashboard');
                Route::match(['get', 'post'],'/profile', 'profile')->name('admin_profile');
                Route::match(['get', 'post'],'/change_password', 'change_password')->name('admin_change_password');
            });

            Route::controller('MemberController')->prefix('member')->group(function () {
                Route::match(['get', 'post'], '/listing', 'member_listing')->name('member_listing');
                Route::match(['get', 'post'], '/kyc-listing', 'member_kyc_listing')->name('member_kyc_listing');
                Route::post('/kyc-approval', 'approval')->name('member_kyc_approval');
                Route::match(['get', 'post'], '/add', 'member_add')->name('member_add');
                Route::match(['get', 'post'], '/edit/{id}', 'member_edit')->name('member_edit');
                Route::match(['get', 'post'], '/details/{id}', 'member_details')->name('member_details');
                Route::match(['get', 'post'], '/deposit/{id}', 'member_deposit')->name('member_deposit');
                Route::match(['get', 'post'], '/withdraw_amount/{id}', 'withdraw_amount')->name('withdraw_amount');
                Route::post('/impersonate', 'impersonate')->name('impersonate_user');
            });

            Route::prefix('report')->group(function () {
                Route::match(['get', 'post'], '/commissions/listing', [CommissionsController::class, 'listing'])->name('report_commission');
                Route::match(['get', 'post'], '/commissions/children', [CommissionsController::class, 'listingChildren'])->name('report_commission_children');
                Route::match(['get', 'post'], '/deposits/listing', [DepositController::class, 'listing'])->name('report_deposits');
                Route::match(['get', 'post'], '/deposits/children', [DepositController::class, 'listingChildren'])->name('report_deposits_children');
                Route::post('/import-commissions', [CommissionsController::class, 'store'])->name('import_commission');
                Route::post('/import-deposits', [DepositController::class, 'store'])->name('import_deposit');
                Route::match(['get', 'post'], '/withdrawals/listing', [WithdrawalController::class, 'listing'])->name('report_withdrawal');
                Route::match(['get', 'post'], '/withdrawals/children', [WithdrawalController::class, 'listingChildren'])->name('report_withdrawal_children');
                Route::match(['get', 'post'], '/withdrawal/withdrawal_request/{id}', [WithdrawalController::class, 'approval'])->name('withdrawal_request');
                Route::match(['get', 'post'], '/performance_bonus/listing', [PerformanceBonusController::class, 'performance_bonus_listing'])->name('performance_bonus_listing');
                Route::match(['get', 'post'], '/performance_bonus/approval/{id}', [PerformanceBonusController::class, 'performance_bonus_approval'])->name('performance_bonus_approval');
            });

            Route::controller('ReferralController')->prefix('referral')->group(function () {
                Route::match(['get', 'post'], '/referral_tree', 'referral_tree')->name('referral_tree');
                Route::match(['get', 'post'], '/referral_tree/referral_detail/{id}', 'referral_detail')->name('referral_detail');
                Route::match(['get', 'post'], '/transfer', 'referral_transfer')->name('referral_transfer');
            });

            Route::controller('DepositController')->group(function () {
                Route::post('/import-deposit', 'store');
                Route::post('/export-deposit', 'export');
                Route::post('/deposit_delete', 'delete')->name('deposit_delete');
            });
            Route::controller('WithdrawalController')->group(function () {
                Route::post('/approval-withdrawal/{id}', 'approval');
                Route::post('/import-withdrawal', 'store')->name('import_withdrawal');
            });

            Route::controller('BrokersController')->prefix('broker')->group(function () {
                Route::match(['get', 'post'], '/broker_listing', 'broker_listing')->name('broker_listing');
                Route::match(['get', 'post'], '/broker_add', 'broker_add')->name('broker_add');
                Route::match(['get', 'post'], '/broker_edit/{id}', 'broker_edit')->name('broker_edit');
                Route::post('/broker_delete', 'delete')->name('broker_delete');
            });

            Route::controller('NewsController')->prefix('news')->group(function () {
                Route::match(['get', 'post'], '/news_listing', 'news_listing')->name('news_listing');
                Route::match(['get', 'post'], '/create_news', 'create_news')->name('create_news');
                Route::match(['get', 'post'], '/news_edit/{id}', 'news_edit')->name('news_edit');
                Route::post('/news_delete', 'delete')->name('news_delete');
            });

            Route::controller('EventController')->prefix('event')->group(function () {
                Route::match(['get', 'post'], '/event_listing', 'listing')->name('event_listing');
                Route::match(['get', 'post'], '/create_event', 'create_event')->name('create_event');
                Route::match(['get', 'post'], '/event_edit/{id}', 'event_edit')->name('event_edit');
                Route::post('/event_delete', 'delete')->name('event_delete');
            });

            Route::controller('CommissionsController')->group(function () {
                Route::post('/commission_delete', 'delete')->name('commission_delete');
            });
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    });
});

