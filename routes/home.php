<?php 
 Route::get('/', 'IndexController@index')->name('index');
 
 Route::get('detail/{merchant}', 'DetailsController@path')->name('details');

 Route::get('{catePath}', 'CategoryController@path')->name('category');
 

