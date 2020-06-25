<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Home@index');
Route::get('/{slug?}','Home@erroRota');

//Usuario
Route::post('/usuario','Usuario@salvar')->middleware(['IsAuth','IsAdmin']);
Route::get('/usuario/{usuario}/{senha}/{token}','Usuario@listar')->middleware(['IsAuth','IsAdmin']);
Route::get('/usuario/{usuario}/{senha}/{id}/{token}','Usuario@listar')->middleware(['IsAuth','IsAdmin']);
Route::put('/usuario','Usuario@atualizar')->middleware(['IsAuth','IsAdmin']);
Route::delete('/usuario/{usuario}/{senha}/{id}','Usuario@deletar')->middleware(['IsAuth','IsAdmin']);
Route::get('/usuarioAutorizacao/{usuario}/{senha}/{token}','Usuario@confirmarUsuario');//->middleware(['IsAuth']);