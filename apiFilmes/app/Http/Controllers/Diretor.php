<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Cadastro as CAD;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Diretor extends CAD{

    public function salvar(Request $request){
        
        $params = $request->all();

        $acao = CD::salvar([
            'tabela'=>'diretor',
            'dados'=>[
                'nome'=>$params['nome'],
                'linkPublico'=>$params['link'],
                'biografia'=>$params['biografia']
            ]
        ]);
        
        if( $acao !== false && (int) $acao > 0 ){
            return parent::$resposta->send( $request->all() );
        }else{
            return parent::$resposta->processadoSemResposta();
        }

    }

    public function atualizar(Request $request){
        
        $params = $request->input();

        $acao = CD::alterar([
            'tabela'=>'diretor',
            'campo'=>'id',
            'valor'=>$params['id'],
            'valores'=>[
                'linkPublico'=>$params['link'],
                'biografia'=>$params['biografia']
            ]
        ]);
        
        if( $acao !== false && (int) $acao > 0 ){
            return parent::$resposta->send( $request->all() );
        }else{
            return parent::$resposta->processadoSemResposta();
        }

    }
        
    public function deletar(Request $request, $tabela='diretor'){
        return parent::deletar($request,'diretor');
    }

    public function listar(Request $request,$tabela='diretor'){
        return parent::listar($request,'diretor');
    }

}