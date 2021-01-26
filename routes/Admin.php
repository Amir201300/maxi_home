<?php

Route::post('/admin/login', 'AuthController@login')->name('admin.login');

Route::prefix('Admin')->group(function () {
    Route::get('/login', function () {
        return view('Admin.loginAdmin');
    });
    Route::group(['middleware' => 'roles', 'roles' => ['Admin']], function () {

        Route::get('/logout/logout', 'AuthController@logout')->name('user.logout');
        Route::get('/home', 'AuthController@index')->name('admin.dashboard');

        // Profile Route
        Route::prefix('profile')->group(function () {
            Route::get('/index', 'profileController@index')->name('profile.index');
            Route::post('/index', 'profileController@update')->name('profile.update');
        });

        // Category Route
        Route::prefix('Store')->group(function () {
            Route::get('/index', 'StoreController@index')->name('Store.index');
            Route::get('/allData', 'StoreController@allData')->name('Store.allData');
            Route::post('/create', 'StoreController@create')->name('Store.create');
            Route::get('/edit/{id}', 'StoreController@edit')->name('Store.edit');
            Route::post('/update', 'StoreController@update')->name('Store.update');
            Route::get('/destroy/{id}', 'StoreController@destroy')->name('Store.destroy');
            Route::get('/ChangeStatus/{id}', 'StoreController@ChangeStatus')->name('Store.ChangeStatus');
        });


    });
});

