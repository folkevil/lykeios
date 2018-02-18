<?php

/*
|--------------------------------------------------------------------------
| Backoffice API Routes
|--------------------------------------------------------------------------
|
| Here are where registered the Backoffice API routes. These routes are
| loaded by the RouteServiceProvider within a group which is assigned
| the "api" and "auth:api" middleware group.
|
*/

Route::get('courses', 'CoursesController@index');
Route::get('courses/{course}', 'CoursesController@show');
