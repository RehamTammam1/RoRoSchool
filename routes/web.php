<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;




require __DIR__.'/auth.php';


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::group(['middleware'=>['guest']],function(){
            Route::get('/', function () {
                return view('auth.login');
            });

        });

        
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::group(['namespace'=>'Grades'],function(){
            Route::resource('grades', 'GradeController');

        });
        Route::group(['namespace'=>'Stages'],function(){
            Route::resource('stages', 'StageController');

        });


    
    });