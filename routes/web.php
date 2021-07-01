<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Livewire\Admin\Employees;
use App\Http\Livewire\Admin\NewEmployee;
use App\Http\Livewire\Admin\Position\ListPosition;
use App\Http\Livewire\Admin\Project\ListProject;
use App\Http\Livewire\Admin\Schedule\ListSchedule;
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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=> 'auth'], function(){
    Route::group(['prefix' => 'admin', 'as'=> 'admin.'],function(){
     
        //  Route::post('admin/settings/save-settings',[SettingsController::class,'update'])->name('settings.update');
        //  Route::get('register-employee',[Employees::class,'create'])->name('employees.create');

    Route::get('new-employee',NewEmployee::class)->name('newEmployee');
    Route::get('list-position',ListPosition::class)->name('list-position');
    Route::get('list-schedule',ListSchedule::class)->name('list-schedule');
    Route::get('list-projects',ListProject::class)->name('list-projects');
    
        //  Route::resource('positions', PositionController::class);
    
         

    });
});