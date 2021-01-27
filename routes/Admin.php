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

        // Store Route
        Route::prefix('Store')->group(function () {
            Route::get('/index', 'StoreController@index')->name('Store.index');
            Route::get('/allData', 'StoreController@allData')->name('Store.allData');
            Route::post('/create', 'StoreController@create')->name('Store.create');
            Route::get('/edit/{id}', 'StoreController@edit')->name('Store.edit');
            Route::post('/update', 'StoreController@update')->name('Store.update');
            Route::get('/destroy/{id}', 'StoreController@destroy')->name('Store.destroy');
            Route::get('/ChangeStatus/{id}', 'StoreController@ChangeStatus')->name('Store.ChangeStatus');
        });

        // AdminType Route
        Route::prefix('AdminType')->group(function () {
            Route::get('/index', 'AdminTypeController@index')->name('AdminType.index');
            Route::get('/allData', 'AdminTypeController@allData')->name('AdminType.allData');
            Route::post('/create', 'AdminTypeController@create')->name('AdminType.create');
            Route::get('/edit/{id}', 'AdminTypeController@edit')->name('AdminType.edit');
            Route::post('/update', 'AdminTypeController@update')->name('AdminType.update');
            Route::get('/destroy/{id}', 'AdminTypeController@destroy')->name('AdminType.destroy');
        });
        // StatusTypes Routes
        Route::prefix('StatusTypes')->group(function () {
            Route::get('/index', 'StatusTypesController@index')->name('StatusTypes.index');
            Route::get('/allData', 'StatusTypesController@allData')->name('StatusTypes.allData');
            Route::post('/create', 'StatusTypesController@create')->name('StatusTypes.create');
            Route::get('/edit/{id}', 'StatusTypesController@edit')->name('StatusTypes.edit');
            Route::post('/update', 'StatusTypesController@update')->name('StatusTypes.update');
            Route::get('/destroy/{id}', 'StatusTypesController@destroy')->name('StatusTypes.destroy');
        });

        // Category Routes
        Route::prefix('Category')->group(function () {
            Route::get('/index', 'CategoryController@index')->name('Category.index');
            Route::get('/allData', 'CategoryController@allData')->name('Category.allData');
            Route::post('/create', 'CategoryController@create')->name('Category.create');
            Route::get('/edit/{id}', 'CategoryController@edit')->name('Category.edit');
            Route::post('/update', 'CategoryController@update')->name('Category.update');
            Route::get('/destroy/{id}', 'CategoryController@destroy')->name('Category.destroy');
        });

        // PaymentType Routes

        Route::prefix('PaymentType')->group(function () {
            Route::get('/index', 'PaymentTypeController@index')->name('PaymentType.index');
            Route::get('/allData', 'PaymentTypeController@allData')->name('PaymentType.allData');
            Route::post('/create', 'PaymentTypeController@create')->name('PaymentType.create');
            Route::get('/edit/{id}', 'PaymentTypeController@edit')->name('PaymentType.edit');
            Route::post('/update', 'PaymentTypeController@update')->name('PaymentType.update');
            Route::get('/destroy/{id}', 'PaymentTypeController@destroy')->name('PaymentType.destroy');
        });
        // User Routs
        Route::prefix('User')->group(function () {
            Route::get('/index', 'UserController@index')->name('User.index');
            Route::get('/allData', 'UserController@allData')->name('User.allData');
            Route::post('/create', 'UserController@create')->name('User.create');
            Route::get('/edit/{id}', 'UserController@edit')->name('User.edit');
            Route::post('/update', 'UserController@update')->name('User.update');
            Route::get('/destroy/{id}', 'UserController@destroy')->name('User.destroy');
        });

        // Supplier Routes
        Route::prefix('Supplier')->group(function () {
            Route::get('/index', 'SupplierController@index')->name('Supplier.index');
            Route::get('/allData', 'SupplierController@allData')->name('Supplier.allData');
            Route::post('/create', 'SupplierController@create')->name('Supplier.create');
            Route::get('/edit/{id}', 'SupplierController@edit')->name('Supplier.edit');
            Route::post('/update', 'SupplierController@update')->name('Supplier.update');
            Route::get('/destroy/{id}', 'SupplierController@destroy')->name('Supplier.destroy');
        });

        // Admin Routes
        Route::prefix('Admin')->group(function () {
            Route::get('/index', 'AdminController@index')->name('Admin.index');
            Route::get('/allData', 'AdminController@allData')->name('Admin.allData');
            Route::post('/create', 'AdminController@create')->name('Admin.create');
            Route::get('/edit/{id}', 'AdminController@edit')->name('Admin.edit');
            Route::post('/update', 'AdminController@update')->name('Admin.update');
            Route::get('/destroy/{id}', 'AdminController@destroy')->name('Admin.destroy');
        });

        // Product Routes
        Route::prefix('Product')->group(function () {
            Route::get('/index', 'ProductController@index')->name('Product.index');
            Route::get('/allData', 'ProductController@allData')->name('Product.allData');
            Route::post('/create', 'ProductController@create')->name('Product.create');
            Route::get('/edit/{id}', 'ProductController@edit')->name('Product.edit');
            Route::post('/update', 'ProductController@update')->name('Product.update');
            Route::get('/destroy/{id}', 'ProductController@destroy')->name('Product.destroy');
            Route::get('/showProduct/{id}', 'ProductController@showProduct')->name('Product.showProduct');
        });

        // ProductStore Routes
        Route::prefix('ProductStore')->group(function () {
            Route::get('/index', 'ProductStoreController@index')->name('ProductStore.index');
            Route::get('/allData/{id}', 'ProductStoreController@allData')->name('ProductStore.allData');
            Route::post('/create', 'ProductStoreController@create')->name('ProductStore.create');
            Route::get('/edit/{id}', 'ProductStoreController@edit')->name('ProductStore.edit');
            Route::post('/update', 'ProductStoreController@update')->name('ProductStore.update');
            Route::get('/destroy/{id}', 'ProductStoreController@destroy')->name('ProductStore.destroy');
        });

        // MoneyDaily Routes
        Route::prefix('MoneyDaily')->group(function () {
            Route::get('/index', 'MoneyDailyController@index')->name('MoneyDaily.index');
            Route::get('/allData', 'MoneyDailyController@allData')->name('MoneyDaily.allData');
            Route::post('/create', 'MoneyDailyController@create')->name('MoneyDaily.create');
            Route::get('/edit/{id}', 'MoneyDailyController@edit')->name('MoneyDaily.edit');
            Route::post('/update', 'MoneyDailyController@update')->name('MoneyDaily.update');
            Route::get('/destroy/{id}', 'MoneyDailyController@destroy')->name('MoneyDaily.destroy');
        });

        //InvoiceSale Routes
        Route::prefix('InvoiceSale')->group(function () {
            Route::get('/index', 'InvoiceSaleController@index')->name('InvoiceSale.index');
            Route::get('/allData', 'InvoiceSaleController@allData')->name('InvoiceSale.allData');
            Route::post('/create', 'InvoiceSaleController@create')->name('InvoiceSale.create');
            Route::get('/edit/{id}', 'InvoiceSaleController@edit')->name('InvoiceSale.edit');
            Route::post('/update', 'InvoiceSaleController@update')->name('InvoiceSale.update');
            Route::get('/destroy/{id}', 'InvoiceSaleController@destroy')->name('InvoiceSale.destroy');
            Route::get('/showInvoiceSale/{id}', 'InvoiceSaleController@showInvoiceSale')->name('InvoiceSale.showInvoiceSale');
        });

        //InvoiceSale Routes
        Route::prefix('InvoiceDetials')->group(function () {
            Route::get('/index/{id}', 'InvoiceDetialsController@index')->name('InvoiceDetials.index');
            Route::get('/allData/{id}', 'InvoiceDetialsController@allData')->name('InvoiceDetials.allData');
            Route::post('/create', 'InvoiceDetialsController@create')->name('InvoiceDetials.create');
            Route::get('/edit/{id}', 'InvoiceDetialsController@edit')->name('InvoiceDetials.edit');
            Route::post('/update', 'InvoiceDetialsController@update')->name('InvoiceDetials.update');
            Route::get('/destroy/{id}', 'InvoiceDetialsController@destroy')->name('InvoiceDetials.destroy');
        });
    });
});

