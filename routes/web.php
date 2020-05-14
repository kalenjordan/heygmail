<?php

Route::get('/', 'IndexController@welcome');

Route::get('/auth', 'AuthController@auth');
Route::get('/logout', 'AuthController@logout');
Route::get('/auth/callback', 'AuthController@handleGoogleCallback');