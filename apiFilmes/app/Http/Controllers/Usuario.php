<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Email\Email;
use App\Http\Controllers\Cadastro as CAD;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Usuario extends CAD{

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
            
            $msg = "Olá ".$params['nomeUsuario'].", você se cadastrou em nossa Api. Seu token é: ".sha1($params['nomeUsuario'].$params['email']);

            $link = env('APP_URL').":".env('API_PORT')."/usuarioAutorizacao/".$params['nomeUsuario']."/".$params['senhaUsuario']."/".sha1($params['nomeUsuario'].$params['email']);
            
            $data['endereco']   = $params['email'];
            $data['nome']       = $params['nomeUsuario'];
            $data['assunto']    = "Confirme seu Cadastro na apiFilmes";
            $data['html']       = view('email.email')->with( ['data'=>['message'=>$msg,'link'=>$link] ] )->render();

            Email::sendEmail($data);

            return self::$resposta->send( $request->all() );

        }else{
            return self::$resposta->processadoSemResposta();
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
                'email'=>$params['email'],
                'tokenCompleto'=>sha1($params['nomeUsuario'].$params['email']) . env('KEY_APP_API'),
                'tokenUsuario'=>sha1($params['nomeUsuario'].$params['email']),
                'confirmado'=>0
            ]
        ]);
        
        if( $acao !== false && (int) $acao > 0 ){

            $msg = "Olá ".$params['nomeUsuario'].", você atualizou seu cadastro em nossa Api. Seu token é: ".sha1($params['nomeUsuario'].$params['email']);

            $link = env('APP_URL').":".env('API_PORT')."/usuarioAutorizacao/".$params['nomeUsuario']."/".$params['senhaUsuario']."/".sha1($params['nomeUsuario'].$params['email']);
            
            $data['endereco']   = $params['email'];
            $data['nome']       = $params['nomeUsuario'];
            $data['assunto']    = "Confirme seu Cadastro na apiFilmes";
            $data['html']       = view('email.email')->with( ['data'=>['message'=>$msg,'link'=>$link] ] )->render();

            Email::sendEmail($data);

            return self::$resposta->send( $request->all() );
        }else{
            return self::$resposta->processadoSemResposta();
        }

    }

    public function confirmarUsuario(Request $request){
        
        //verifica se tem os parametros necessários
        if( !isset($request->usuario) || empty($request->usuario) || !isset($request->senha) || empty($request->senha) || !isset($request->senha) || empty($request->senha) ){
            return self::$resposta->erroRequisicao("Parâmetros obrigatórios: usuario, senha e token...");
        }

        //recupera dados do usuário para comparar token
        $dadosToken = DB::table('usuario')
            ->select('tokenCompleto','tokenUsuario')
            ->where('nmUsuario',$request->usuario)
            ->get();
        
        //usuário não encontrado
        if(!count($dadosToken)){
            return self::$resposta->erroAutenticar("Usuario não encontrado...");
        }

        //token usuário inválido
        $tokenBanco = $dadosToken[0]->tokenUsuario;

        if( $request->token != $tokenBanco ){
            return self::$resposta->erroAutenticar("Token inválido");
        }

        //atualiza o campo confirmado
        $acao = CD::alterar([
            'tabela'=>'usuario',
            'campo'=>'nmUsuario',
            'valor'=>$request->usuario,
            'valores'=>[ 'confirmado'=>1 ]
        ]);

        if( $acao !== false && (int) $acao > 0 ){
            return view('doc.index')->with([
                'data'=>[
                    'confirmacaoEmailUsuario'=>'Seu token foi confirmado com sucesso, agora basta acessar a documentação da API e conhecer um pouco mais sobre suas funcionalidades!!'
                ]
            ]);
        }else{
            return self::$resposta->processadoSemResposta();
        }
        
    }

    public function listar(Request $request,$tabela='usuario'){
        return parent::listar($request,'usuario');
    }

    public function deletar(Request $request,$tabela='usuario'){
        return parent::deletar($request,'usuario');
    }

}