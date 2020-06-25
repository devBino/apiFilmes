<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Usuario{

    private $resposta;

    public function __construct(){
        $this->resposta = new Resposta();
    }

    public function listar(Request $request){
        
        //busca os usuarios
        $dados = DB::table('usuario')->select('id','nmUsuario','email','confirmado','cdPermissao','dtUpdate');
        
        //verifica parametro(s)
        if( isset($request->id) ){
            $dados = $dados->where('id',$request->id);
        }

        $dados = $dados->get();
        
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
            'tabela'=>'usuario',
            'dados'=>[
                'nmUsuario'=>$params['nomeUsuario'],
                'dsSenha'=>sha1( env('KEY_APP_API') . $params['senhaUsuario'] ),
                'email'=>$params['email'],
                'tokenCompleto'=>sha1($params['nomeUsuario'].$params['email']) . env('KEY_APP_API'),
                'tokenUsuario'=>sha1($params['nomeUsuario'].$params['email']),
                'cdPermissao'=>2
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
            'tabela'=>'usuario',
            'campo'=>'id',
            'valor'=>$params['id'],
            'valores'=>[
                'nmUsuario'=>$params['nomeUsuario'],
                'dsSenha'=>sha1( env('KEY_APP_API') . $params['senhaUsuario'] ),
                'email'=>$params['email']
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
            'tabela'=>'usuario',
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