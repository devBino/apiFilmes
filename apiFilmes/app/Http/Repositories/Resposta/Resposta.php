<?php
namespace App\Http\Repositories\Resposta;

use App\Http\Interfaces\Resposta as RESP;

class Resposta implements RESP{

    public function send(Array $params){
        
        $msg = "Api Filmes Magic Design V 1.0";

        if( count($params) ){
            $msg = "Solicitação Processada com sucesso!";
        }

        return response( ['message'=>$msg,'success'=>true,'data'=>$params], 200 )->header('Content-Type', 'application/json');
    }

    public static function erroAutenticar($msg = null){
        $message = !is_null($msg) ? $msg : 'Erro ao autenticar...';
        return response(['message'=>$message,'success'=>false], 401)->header('Content-Type', 'application/json');
    }

    public static function erroPermissao($msg = null){
        $message = !is_null($msg) ? $msg : 'Permissão negada...';
        return response(['message'=>$message,'success'=>false], 403)->header('Content-Type', 'application/json');
    }

    public static function erroRota(){
        return response(['message'=>'Recurso não encontrado...','success'=>false], 404)->header('Content-Type','application/json');
    }

    public static function processadoSemResposta(){
        return response(['message'=>'Requisição aceita, mas nenhum registro foi afetado...','success'=>false],202)
            ->header('Content-Type','application/json');
    }

    public static function erroRequisicao($msg = null){
        $message = !is_null($msg) ? $msg : 'Nem todos os parâmetros foram informados...';
        return response(['message'=>$message,'success'=>false], 400)->header('Content-Type', 'application/json');
    }

}