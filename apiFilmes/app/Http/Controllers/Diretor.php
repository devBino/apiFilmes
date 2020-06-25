<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Diretor{

    private $resposta;

    public function __construct(){
        $this->resposta = new Resposta();
    }

    public function listar(Request $request){
        
        //busca os diretores
        $dados = DB::table('diretor')->select();
        
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
            'tabela'=>'diretor',
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
            'tabela'=>'diretor',
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
            'tabela'=>'diretor',
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