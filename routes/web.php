<?php

Route::get('/', 'IndexController@welcome');

Route::get('/auth', 'AuthController@auth');
Route::get('/logout', 'AuthController@logout');
Route::get('/auth/callback', 'AuthController@handleGoogleCallback');

Route::get('/account/settings', 'AccountController@settings');
Route::post('/account/settings', 'AccountController@settingsPost');