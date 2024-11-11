<?php

use App\Http\Livewire\AccountManagements;
use App\Http\Livewire\Cities;
use App\Http\Livewire\Countries;
use App\Http\Livewire\CreditManagements;
use App\Http\Livewire\Currencies;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\DocumentTypes;
use App\Http\Livewire\RegisterOperations;
use App\Http\Livewire\ResellerManagements;
use App\Http\Livewire\Roles;
use App\Http\Livewire\States;
use App\Http\Livewire\Users;
use App\Http\Livewire\Profiles;
use App\Http\Livewire\WorkOrder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profiles', Profiles::class)->name('profiles');
});

Route::middleware(['auth', 'verified', 'inactive'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/city',      Cities::class)->name('cities');
    Route::get('/country',   Countries::class)->name('countries');
    Route::get('/work_order', WorkOrder::class)->name('work_orders');
    Route::get('/document',  DocumentTypes::class)->name('document_types');
    Route::get('/role',      Roles::class)->name('roles');
    Route::get('/state',     States::class)->name('states');
    Route::get('/user',      Users::class)->name('users');
    // Route::get('/account_managements',      AccountManagements::class)->name('account_managements');
    // Route::get('/reseller_managements',      ResellerManagements::class)->name('reseller_managements');
    // Route::get('/register_operations',      RegisterOperations::class)->name('register_operations');
    // Route::get('/credit_managements',      CreditManagements::class)->name('credit_managements');

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        app('files')->link(
            storage_path('app/public'),
            public_path('storage')
        );
        return redirect()->url('/');
    });
});
require __DIR__ . '/auth.php';
