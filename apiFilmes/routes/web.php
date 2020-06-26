<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Home@index');
Route::get('/documentacao','Home@documentacao');

Route::get('/{slug?}','Home@erroRota');
/*Route::post('/{slug?}','Home@erroRota');
Route::put('/{slug?}','Home@erroRota');
Route::delete('/{slug?}','Home@erroRota');*/

//Usuario
Route::post('/usuario','Usuario@salvar')->middleware(['IsAuth','IsAdmin']);
Route::get('/usuario/{usuario}/{senha}/{token}','Usuario@listar')->middleware(['IsAuth','IsAdmin']);
Route::get('/usuario/{usuario}/{senha}/{token}/{id}','Usuario@listar')->middleware(['IsAuth','IsAdmin']);
Route::put('/usuario','Usuario@atualizar')->middleware(['IsAuth','IsAdmin']);
Route::delete('/usuario','Usuario@deletar')->middleware(['IsAuth','IsAdmin']);
Route::get('/usuarioAutorizacao/{usuario}/{senha}/{token}','Usuario@confirmarUsuario');

//Diretor
Route::post('/diretor','Diretor@salvar')->middleware(['IsAuth']);
Route::get('/diretor/{usuario}/{senha}/{token}','Diretor@listar')->middleware(['IsAuth']);
Route::get('/diretor/{usuario}/{senha}/{token}/{id}','Diretor@listar')->middleware(['IsAuth']);
Route::put('/diretor','Diretor@atualizar')->middleware(['IsAuth']);
Route::delete('/diretor','Diretor@deletar')->middleware(['IsAuth']);

//Filme
Route::post('/filme','Filme@salvar')->middleware(['IsAuth']);
Route::get('/filme/{usuario}/{senha}/{token}','Filme@listar')->middleware(['IsAuth']);
Route::get('/filme/{usuario}/{senha}/{token}/{id}','Filme@listar')->middleware(['IsAuth']);
Route::put('/filme','Filme@atualizar')->middleware(['IsAuth']);
Route::delete('/filme','Filme@deletar')->middleware(['IsAuth']);

//Ator
Route::post('/ator','Ator@salvar')->middleware(['IsAuth']);
Route::get('/ator/{usuario}/{senha}/{token}','Ator@listar')->middleware(['IsAuth']);
Route::get('/ator/{usuario}/{senha}/{token}/{id}','Ator@listar')->middleware(['IsAuth']);
Route::put('/ator','Ator@atualizar')->middleware(['IsAuth']);
Route::delete('/ator','Ator@deletar')->middleware(['IsAuth']);

//Elenco
Route::post('/elenco','Elenco@salvar')->middleware(['IsAuth']);
Route::get('/elenco/{usuario}/{senha}/{token}','Elenco@listar')->middleware(['IsAuth']);
Route::get('/elenco/{usuario}/{senha}/{token}/{id}','Elenco@listar')->middleware(['IsAuth']);
Route::delete('/elenco','Elenco@deletar')->middleware(['IsAuth']);