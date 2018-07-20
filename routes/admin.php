<?php
/**
 * 后台管理路由
 */

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout')->name('admin.logout');

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/', 'IndexController@index')->name('admin.index');

    // 管理员相关操作
    Route::group(['prefix' => 'admin'], function () {
        // 当前管理员修改密码
        Route::patch('password/change', 'AdminController@passwordChange')->name('admin.admin.password.change');

        Route::get('index', 'AdminController@index')->name('admin.admin.index');
        Route::post('admin', 'AdminController@create')->name('admin.admin.create');

        // 管理员的管理
        Route::group(['prefix' => '{admin}'], function () {
            Route::delete('/', 'AdminController@destory')->name('admin.admin.destory');
            Route::patch('password/reset', 'AdminController@passwordReset')->name('admin.admin.password.reset');
            Route::patch('enable', 'AdminController@enable')->name('admin.admin.enable');
            Route::patch('disable', 'AdminController@disable')->name('admin.admin.disable');
        });
    });

    // 栏目管理
    Route::group(['prefix' => 'category'], function () {
        Route::get('index', 'CategoryController@index')->name('admin.category.index');

        Route::group(['prefix' => '{category}'], function () {
            Route::get('/', 'CategoryController@detail')->name('admin.category.detail');
            Route::put('/', 'CategoryController@update')->name('admin.category.update');
            Route::patch('icon', 'CategoryController@setIcon')->name('admin.category.icon');

            Route::group(['prefix' => 'display'], function () {
                Route::patch('hide', 'CategoryController@displayHide')->name('admin.category.display.hide');
                Route::patch('show', 'CategoryController@displayShow')->name('admin.category.display.show');
            });

            Route::group(['prefix' => 'tag'], function () {
                Route::post('/', 'CategoryController@tagCreate')->name('admin.category.tag.create');
                Route::put('{tag}', 'CategoryController@tagUpdate')->name('admin.category.tag.update');
            });
        });

    });

    // 商户管理
    Route::group(['prefix' => 'merchant'], function () {
        Route::get('index', 'MerchantController@index')->name('admin.merchant.index');
        Route::get('create', 'MerchantController@create')->name('admin.merchant.create');
        Route::get('search', 'MerchantController@search')->name('admin.merchant.search');

        Route::group(['prefix' => '{merchant}'], function () {
            Route::get('/', 'MerchantController@edit')->name('admin.merchant.edit');
            Route::post('/', 'MerchantController@store')->name('admin.merchant.store');
            Route::put('/', 'MerchantController@update')->name('admin.merchant.update');

            Route::group(['prefix' => 'image'], function () {
                Route::post('upload', 'MerchantController@imageUpload')->name('admin.merchant.image.upload');
                Route::patch('{image}/sortord', 'MerchantController@imageSetSortord')->name('admin.merchant.image.sortord');
            });

            Route::group(['prefix' => 'tag'], function () {
                Route::post('/', 'MerchantController@tagCreate')->name('admin.merchant.tag.create');
                Route::put('{tag}', 'MerchantController@tagUpdate')->name('admin.merchant.tag.update');
            });

            Route::group(['prefix' => 'product'], function () {
                Route::get('list', 'MerchantController@productList')->name('admin.merchant.product.list');
                Route::get('create', 'MerchantController@productCreate')->name('admin.merchant.product.create');
                Route::get('{product}/edit', 'MerchantController@productEdit')->name('admin.merchant.product.edit');
            });
        });
    });

    // 产品管理
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', 'ProductController@index')->name('admin.product.index');
        Route::get('create', 'ProductController@create')->name('admin.product.create');

        Route::group(['prefix' => '{product}'], function () {
            Route::get('/', 'ProductController@edit')->name('admin.product.edit');
            Route::post('/', 'ProductController@store')->name('admin.product.store');
            Route::put('/', 'ProductController@update')->name('admin.product.update');
        });
    });

    // 图片操作
    Route::group(['prefix' => 'image'], function () {
        Route::delete('{image}', 'ImageController@delete')->name('admin.image.delete');
    });

    // tag 操作
    Route::group(['prefix' => 'tag'], function () {
        Route::get('{tag}', 'TagController@detail')->name('admin.tag.detail');
        Route::delete('{tag}', 'TagController@destory')->name('admin.tag.destory');
        Route::patch('{tag}/hide', 'TagController@displayHide')->name('admin.tag.hide');
        Route::patch('{tag}/show', 'TagController@displayShow')->name('admin.tag.show');
    });
});
