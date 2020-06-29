<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Cadastro{

    public static $resposta;

    public function __construct(){
        self::$resposta = new Resposta();
    }

    public function listar(Request $request,$tabela){

        //busca os atores
        $dados = DB::table($tabela)->select();
        
        //verifica parametro(s)
        if( isset($request->id) ){
            $dados = $dados->where('id',$request->id);
        }

        $dados = $dados->get();
        
        if( !count($dados) ){
            return self::$resposta->processadoSemResposta();
        }

        //limpa o array
        $arrResponse = [];

        for( $i=0;$i<count($dados); $i++ ){
            $arrResponse[] = $dados[$i];
        }

        //responde com os dados da busca
        return self::$resposta->send( (array) $arrResponse);

    }

    public function deletar(Request $request, $tabela){
        
        $acao = CD::deletar([
            'tabela'=>$tabela,
            'campo'=>'id',
            'valor'=>$request->id
        ]);

        if( $acao !== false && (int) $acao > 0 ){
            return self::$resposta->send( ['id'=>$request->id,'status'=>'Registro deletado'] );
        }else{
            return self::$resposta->processadoSemResposta();
        }

    }

}