<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Users\ClientController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Journals\JournalController;
use App\Http\Controllers\Settings\PaymentController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Submissions\CommentController;
use App\Http\Controllers\Submissions\PublishController;
use App\Http\Controllers\Journals\TransactionController;
use App\Http\Controllers\Journals\RegistrationController;
use App\Http\Controllers\Submissions\CertificateController;
use App\Http\Controllers\Submissions\SelectReviewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return redirect(RouteServiceProvider::HOME);
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'permission', 'verified'])->group(function () {
  Route::prefix('settings')->group(function () {
    // Role management.
    Route::resource('roles', RoleController::class)->except('show');

    // Management password users.
    Route::get('users/password/{user}', [PasswordController::class, 'showChangePasswordForm'])->name('users.password');
    Route::post('users/password', [PasswordController::class, 'store']);

    // User management.
    Route::patch('users/status/{user}', [UserController::class, 'status'])->name('users.status');
    Route::post('users/image/delete/{user}', [UserController::class, 'image'])->name('users.image');
    Route::resource('users', UserController::class);

    // Payment management.
    Route::patch('payments/status/{payment}', [PaymentController::class, 'status'])->name('payments.status');
    Route::resource('payments', PaymentController::class);

    // Participant and Pemakalah management.
    Route::prefix('users')->group(function () {
      Route::resource('clients', ClientController::class)->except('index', 'destroy', 'show');
    });
  });

  Route::prefix('journals')->group(function () {
    Route::resource('journals', JournalController::class);
    Route::resource('transactions', TransactionController::class)->except('edit');
    Route::resource('registrations', RegistrationController::class)->except('show');
  });

  Route::prefix('submissions')->group(function () {
    // Select Reviewer (Admin Only)
    Route::resource('select-reviewers', SelectReviewerController::class)->only('store');

    // Comments
    Route::resource('comments', CommentController::class)->only('store', 'destroy');

    // Publishes
    Route::resource('publishes', PublishController::class)->only('index', 'create', 'store', 'update');

    // Certificates
    Route::patch('certificates/print', [CertificateController::class, 'print'])->name('certificates.print');
    Route::resource('certificates', CertificateController::class)->only('index');
  });
});
