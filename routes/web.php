<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::group(['middleware'=>['auth']], function(){
    Route::resource('/class', ClassesController::class);
});
Route::group(['middleware'=>['auth']], function(){
    Route::resource('/teacher', TeacherController::class);
});
Route::group(['middleware'=>['auth']], function(){
    Route::resource('/subject', SubjectsController::class);
});
Route::group(['middleware'=>['auth']], function(){
    Route::resource('/student', StudentController::class);
});

//Create , edit, delete roles
Route::get('role', [RoleController::class, 'roles'])->name('roles');
Route::post('role', [RoleController::class, 'storeRole'])->name('storeRole');
Route::put('role/{role}', [RoleController::class, 'updateRole'])->name('updateRole');
Route::delete('role/{role}', [RoleController::class, 'destroyRole'])->name('destroyRole');

// Assign roles to users
Route::get('usersRole', [RoleController::class, 'users'])->name('usersRole');
Route::post('users/{users}', [RoleController::class, 'updateUserRole'])->name('updateUserRole');//Assign user role

Route::get('routine', [ClassesController::class, 'generate'])->name('routine');
