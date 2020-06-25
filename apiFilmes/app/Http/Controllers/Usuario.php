<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Email\Email;
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
            

            $msg = "Olá ".$params['nomeUsuario'].", você se cadastrou em nossa Api.";
            $msg = utf8_encode($msg);

            $link = env('APP_URL').":".env('API_PORT')."/usuarioAutorizacao/".$params['nomeUsuario']."/".$params['senhaUsuario']."/".sha1($params['nomeUsuario'].$params['email']);
            
            $data['endereco']   = $params['email'];
            $data['nome']       = $params['nomeUsuario'];
            $data['assunto']    = "Confirme seu Cadastro na apiFilmes";
            $data['html']       = view('email.email')->with( ['data'=>['message'=>$msg,'link'=>$link] ] )->render();

            Email::sendEmail($data);

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

    public function confirmarUsuario(Request $request){
        
        //verifica se tem os parametros necessários
        if( !isset($request->usuario) || empty($request->usuario) || !isset($request->senha) || empty($request->senha) || !isset($request->senha) || empty($request->senha) ){
            return $this->resposta->erroRequisicao("Parâmetros obrigatórios: usuario, senha e token...");
        }

        //recupera dados do usuário para comparar token
        $dadosToken = DB::table('usuario')
            ->select('tokenCompleto','tokenUsuario')
            ->where('nmUsuario',$request->usuario)
            ->get();
        
        //usuário não encontrado
        if(!count($dadosToken)){
            return $this->resposta->erroAutenticar("Usuario não encontrado...");
        }

        //token usuário inválido
        $tokenBanco = $dadosToken[0]->tokenUsuario;

        if( $request->token != $tokenBanco ){
            return $this->resposta->erroAutenticar("Token inválido");
        }

        //atualiza o campo confirmado
        $acao = CD::alterar([
            'tabela'=>'usuario',
            'campo'=>'nmUsuario',
            'valor'=>$request->usuario,
            'valores'=>[ 'confirmado'=>1 ]
        ]);

        if( $acao !== false && (int) $acao > 0 ){
            return $this->resposta->send( ['status'=>'Usuário autenticado!'] );
        }else{
            return $this->resposta->processadoSemResposta();
        }
        
    }

}