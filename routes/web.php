<?php

Route::get('/', 'IndexController@welcome');

Route::get('/auth', 'AuthController@auth');
Route::get('/logout', 'AuthController@logout');
Route::get('/auth/callback', 'AuthController@handleGoogleCallback');

Route::get('/account/settings', 'AccountController@settings');
Route::post('/account/settings', 'AccountController@settingsPost');

Route::get('/account/things', 'AccountController@thingList');
Route::get('/account/things/new', 'AccountController@thingNew');
Route::post('/account/things/new', 'AccountController@thingNewPost');
Route::get('/account/things/{id}', 'AccountController@thingEdit');
Route::post('/account/things/{id}', 'AccountController@thingEditPost');
Route::get('/account/things/{id}/delete', 'AccountController@thingDelete');

Route::get('/blog/{slug}', 'IndexController@blog');