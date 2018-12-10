<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return 'home';
});

Route::get('/usuarios', 'UserController@index')->name('users.index');

Route::get('/usuarios/{user}', 'UserController@show')
	->where('user', '[0-9]+')
	->name('users.show'); 

// Indica que solo los usuarios numericos van a tomar esta ruta (Expresiones regulares)
// Laravel tomara las rutas de la primera a la ultima y luego de encontrar un coincidencia ya dejara de buscar

Route::get('/usuarios/nuevo', 'UserController@create')->name('users.create');

Route::post('/usuarios/', 'UserController@store')->name('users.store');

Route::get('/usuarios/{user}/editar', 'UserController@edit')
->name('users.edit');

Route::put('/usuarios/{user}', 'UserController@update');

Route::delete('/usuarios/{user}', 'UserController@destroy')->name('users.destroy');

// Signo ? es opcional, se iguala la variable a null en la funcion
Route::get('/saludo/{name}/{nickname?}', 'WelcomeUserController');


