<?php

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\CronController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerTypeController;
use App\Http\Controllers\Admin\LoanCategoriesController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\RoleMasterController;
use App\Http\Controllers\Admin\SalaryLevelController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\Admin_Auth_Controller;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Hash;
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

Route::get(
    'info',
    function () {
        return phpinfo();
    }
);

Route::get(
    'laravel_info',
    function () {
        return 'Laravel Version: ' . app()->version();
    }
);

Route::group(['middleware' => ['admin:web']], function () {
    // Admin index routes
    Route::get('/', [AdminController::class, 'index']);
    Route::get('admin', [AdminController::class, 'index']);

    // Admin basic routes
    Route::get('admin/home', [AdminController::class, 'getAdminHome']);
    Route::get('admin/dashboard', [AdminController::class, 'dashboard']);
    //Route::get('admin/profile', [AdminController::class,'getProfile');
    Route::post('admin/profile/{id}', [AdminController::class, 'postProfile']);
    Route::get('admin/changePassword', [AdminController::class, 'getChangePassword']);
    Route::post('admin/changePassword/{id}', [AdminController::class, 'postChangePassword']);
    Route::get('admin/settings', [AdminController::class, 'getAdminSettings']);
    Route::post('admin/settings', [AdminController::class, 'postAdminSettings']);
    Route::get('admin/total-loans', [AdminController::class, 'getTotalLoans']);

    Route::resource('admin/customers', CustomerController::class);
    Route::resource('admin/customer_type', CustomerTypeController::class);
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/roles', RoleMasterController::class);
    Route::resource('admin/loancategories', LoanCategoriesController::class);
    Route::resource('admin/salarylevels', SalaryLevelController::class);
    Route::resource('admin/banks', BankController::class);
    Route::get('admin/customers/create/{tpf_no}', [CustomerController::class, 'create']);

    // Member(s) import
    Route::get('admin/import/members', [AdminController::class, 'getImport']);
    Route::post('admin/import/members', [AdminController::class, 'postImport']);

    // Advance reconciliation
    Route::get('admin/advance-reconciliation', [AccountsController::class, 'getAdvanceReconciliation']);
    Route::post('admin/advance-reconciliation', [AccountsController::class, 'postAdvanceReconciliation']);

    // Payment request routes
    Route::get('admin/import/savings', [AdminController::class, 'getSavingsUpload']);
    Route::get('admin/import/credit-loan', [AdminController::class, 'getCreditLoanUpload']);
    Route::get('admin/import/advance-loan', [AdminController::class, 'getAdvanceLoanUpload']);
    Route::post('admin/import/savings', [AdminController::class, 'postSavingsUpload']);
    Route::post('admin/import/credit-loan', [AdminController::class, 'postCreditLoanUpload']);
    Route::post('admin/import/advance-loan', [AdminController::class, 'postAdvanceLoanUpload']);
    Route::get('download/{file_type}', [AdminController::class, 'getForceDownload']);
    Route::get('admin/generate/advance-repayment-list', [AdminController::class, 'generateAdvancePaymentList']);
    Route::get('admin/generate/credit-repayment-list', [AdminController::class, 'generateCreditPaymentList']);

    // User access routes
    Route::get('admin/roles/get-access/{id}', [RoleMasterController::class, 'getAccess'])->name('roles.get-access');
    Route::post('admin/roles/setAccess/{id}', [RoleMasterController::class, 'setAccess'])->name('roles.set-access');

    // Loan controller routes
    Route::get('admin/loan_section', [LoanController::class, 'index']);
    Route::post('getamt/', [LoanController::class, 'get_loan_cl_amt']);
    Route::post('getyr/', [LoanController::class, 'get_loan_cl_yr']);
    Route::post('admin/loan/depositMoney/{id}', [LoanController::class, 'depositMoney']);
    Route::get('admin/loan_section/viewDetails/{id}', [
        LoanController::class,
        'viewDetails'
    ]);
    Route::get('admin/loan_section/applyLoan/{id}/{scheme}', [LoanController::class, 'applyLoan']);
    Route::get('admin/loan/customerLoanRequests', [LoanController::class, 'customerLoanRequests']);
    Route::get('admin/loan/customerAdvanceRequests', [LoanController::class, 'customerAdvanceRequests']);
    Route::post('admin/loan_section/saveLoanDetails', [LoanController::class, 'saveLoanDetails']);
    Route::post('admin/loan_section/getTPFDetails', [
        LoanController::class,
        'getTPFDetails'
    ]);

    // Committee controller routes
    Route::post('admin/committee/approval/{id}', [CommitteeController::class, 'approval']);
    Route::get('admin/committee/customerApprovedLoanDetails', [CommitteeController::class, 'customerApprovedLoanDetails']);
    Route::get('admin/committee/viewCustomerLoanDetails/{id}', [CommitteeController::class, 'viewCustomerLoanDetails']);
    Route::get('admin/committee/customerLoanDetails', [CommitteeController::class, 'customerLoanDetails']);

    // Accounts controller routes
    Route::get('admin/accounts/customerApprovedLoanDetails', [AccountsController::class, 'customerApprovedLoanDetails']);
    Route::post('admin/accounts/payNow', [AccountsController::class, 'payNow']);
    Route::get('admin/accounts/DepositedLoans', [AccountsController::class, 'DepositedLoans']);
    Route::get('admin/accounts/viewLoanDetails/{id}', [AccountsController::class, 'viewLoanDetails']);
    Route::get('admin/accounts/payLoan/{id}', [AccountsController::class, 'payLoan']);

    // Member statement route(pdf report)
    Route::get('admin/members/statement/{id}', [CustomerController::class, 'getStatement']);
    Route::get('admin/members/advance-transaction-history/{id}/{loan_id}', [CustomerController::class, 'getAdvanceTransactionHistory']);
});

// Cron routes
Route::get('admin/deduct-administration-fee', [CronController::class, 'deductAdministrationFee']);
Route::get('admin/calculate-loan-interest', [CronController::class, 'calculateLoanInterest']);
Route::get('admin/change-customer-category', [CronController::class, 'changeCustomerCategory']);

// Password reset start
Route::get('admin/forgot-password', [PasswordController::class, 'getEmail']);
Route::post('admin/forgot-password', [PasswordController::class, 'postEmail']);
Route::get('admin/reset-password/{token}', [PasswordController::class, 'getReset']);
Route::post('admin/reset-password', [PasswordController::class, 'postReset']);

// Login and logout
Route::get('admin/login', [Admin_Auth_Controller::class, 'getLogin']);
Route::post('admin/postLogin', [Admin_Auth_Controller::class, 'postLogin']);
Route::get('admin/logout', [Admin_Auth_Controller::class, 'getLogout']);
Route::get('admin/forgotpassword', [Admin_Auth_Controller::class, 'forgotpassword']);
Route::post('admin/postForgotpassword', [Admin_Auth_Controller::class, '@postforgotpassword']);

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
|
| The route(s) applies to front end(website)
|
*/
// Route::get('/', 'HomeController@index');
// Route::get('page/{slug}', 'PageController@index');
// Route::get('login', 'Auth\FrontAuthController@getLogin');
// Route::post('do-login', 'Auth\FrontAuthController@postLogin');
// Route::get('logout', 'Auth\FrontAuthController@getLogout');
// Route::get('dashboard', 'MyDashboardController@index');
// Route::get('profile', 'MyDashboardController@getProfile');
// Route::post('profile', 'MyDashboardController@postProfile');
// Route::get('change-password', 'MyDashboardController@getChangePassword');
// Route::post('change-password', 'MyDashboardController@postChangePassword');

// // Customer loan request routes
// Route::get('share-balance', 'MyDashboardController@getShareHistory');
// Route::get('loan-history', 'MyDashboardController@getLoanHistory');
// Route::get('loan-pdf/{id}', 'MyDashboardController@getLoanPdf');
// Route::get('loan-mypdf', 'MyDashboardController@mypdf');
// Route::get('loan-detail/{id}', [
//     'as' => 'customers.loan.detail',
//     'uses' => 'MyDashboardController@getLoanDetail'
// ]);

// // Password reset request routes
// Route::get('forgot-password', 'Auth\FrontPasswordController@getEmail');
// Route::post('forgot-password', 'Auth\FrontPasswordController@postEmail');

// // Password reset routes
// Route::get('reset-password/{token}', 'Auth\FrontPasswordController@getReset');
// Route::post('reset-password', 'Auth\FrontPasswordController@postReset');


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
