<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta;
use App\Http\Controllers\Cadastro as CAD;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Filme extends CAD{

    public function listar(Request $request,$tabela='filme'){
        return parent::listar($request,'filme');
    }

    public function salvar(Request $request){
        
        $params = $request->all();
        
        $acao = CD::salvar([
            'tabela'=>'filme',
            'dados'=>[
                'nome'=>$params['nome'],
                'dtLancamento'=>date('Y-m-d',strtotime($params['dataLancamento']))." 00:00:00",
                'idDiretor'=>$params['idDiretor'],
                'classificacao'=>$params['classificacao'],
                'genero'=>$params['genero'],
                'duracao'=>$params['duracao'],
                'qtdeOscar'=>$params['quantidadeOscar'],
                'resumo'=>$params['resumo'],
                'urlTrailer'=>$params['urlTrailer']
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
            'tabela'=>'filme',
            'campo'=>'id',
            'valor'=>$params['id'],
            'valores'=>[
                'qtdeOscar'=>$params['quantidadeOscar'],
                'resumo'=>$params['resumo'],
                'urlTrailer'=>$params['urlTrailer']
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
            'tabela'=>'filme',
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