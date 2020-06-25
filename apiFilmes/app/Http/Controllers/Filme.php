<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Filme{

    private $resposta;

    public function __construct(){
        $this->resposta = new Resposta();
    }

    public function listar(Request $request){
        
        //busca os filmes
        $dados = DB::table('filme')->select();
        
        //verifica parametro(s)
        if( isset($request->id) ){
            $dados = $dados->where('id',$request->id);
        }

        $dados = $dados->get();
        
        if( !count($dados) ){
            return $this->resposta->processadoSemResposta();
        }

        //limpa o array
        $arrResponse = [];

        for( $i=0;$i<count($dados); $i++ ){
            $arrResponse[] = $dados[$i];
        }

        //responde com os dados da busca
        return $this->resposta->send( (array) $arrResponse);
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