<?php

Route::prefix(config('database.database_dictionary_uri'))
    ->namespace('\Jw\Database\Dictionary\Controllers')
    ->name('database.dictionary.')->group(function () {

        // 主界面
        Route::view('/', 'database_dictionary::index')->name('page');
        Route::get('/index', 'DatabaseDictionaryController@index')->name('index');

        Route::post('/', 'DatabaseDictionaryController@store')->name('store');

        Route::put('/', 'DatabaseDictionaryController@update')->name('update');

        Route::delete('/', 'DatabaseDictionaryController@destroy')->name('destroy');

        Route::get('/table/index', 'DatabaseDictionaryController@getAllTable')->name('table.index');

        Route::get('/table/construct', 'DatabaseDictionaryController@tableConstruct')->name('table.construct');

        Route::get('/markdown', 'DatabaseDictionaryController@markdown')->name('markdown');
    });
