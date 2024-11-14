<?php

use App\Http\Livewire\Cities;
use App\Http\Livewire\Countries;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\DocumentTypes;
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
    Route::get('/work_order', WorkOrder::class)->name('work_orders');
    Route::get('/document',  DocumentTypes::class)->name('document_types');
    Route::get('/role',      Roles::class)->name('roles');
    Route::get('/state',     States::class)->name('states');
    Route::get('/user',      Users::class)->name('users');

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        app('files')->link(
            storage_path('app/public'),
            public_path('storage')
        );
        return redirect('/dashboard');
    });
});
require __DIR__ . '/auth.php';
