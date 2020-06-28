<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Cadastro as CAD;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Ator extends CAD{

    public function listar(Request $request,$tabela='ator'){
        return parent::listar($request,'ator');
    }

    public function salvar(Request $request){
        
        $params = $request->all();

        $acao = CD::salvar([
            'tabela'=>'ator',
            'dados'=>[
                'nome'=>$params['nome'],
                'linkPublico'=>$params['link'],
                'biografia'=>$params['biografia']
            ]
        ]);
        
        if( $acao !== false && (int) $acao > 0 ){
            return $this->resposta->send( $request->all() );
        }else{
            return $this->resposta->processadoSemResposta();
        }

    }

    public function atualizar(Request $request){
        
        $params = $request->input();

        $acao = CD::alterar([
            'tabela'=>'ator',
            'campo'=>'id',
            'valor'=>$params['id'],
            'valores'=>[
                'linkPublico'=>$params['link'],
                'biografia'=>$params['biografia']
            ]
        ]);
        
        if( $acao !== false && (int) $acao > 0 ){
            return $this->resposta->send( $request->all() );
        }else{
            return $this->resposta->processadoSemResposta();
        }

    }

    public function deletar(Request $request){
        
        $acao = CD::deletar([
            'tabela'=>'ator',
            'campo'=>'id',
            'valor'=>$request->id
        ]);

        if( $acao !== false && (int) $acao > 0 ){
            return $this->resposta->send( ['id'=>$request->id,'status'=>'Registro deletado'] );
        }else{
            return $this->resposta->processadoSemResposta();
        }

    }

}