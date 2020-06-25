<?php
namespace App\Http\Repositories\Acesso;

use Illuminate\Http\Request;
use DB;

class Acesso{

    public static $verificaAdmin = false;

    /**
     * Recebe o $request e redireciona dinamicamente para função
     * padrão processar + Verbo HTTP
     * assim por exemplo tempos processarPOST
     * ai em cada função verifica se existem os dados de  acesso
     * ainda falta adicionar a verificação de token e será feita aqui mesmo
     * nessa classe padrão
    */
    public static function autenticar(Request $request){

        self::$verificaAdmin = false;

        $funcao = "processar".$request->method();
        $countRegistro = self::$funcao($request);
        
        return $countRegistro;

    }

    /**
     * verifica se usuáro tem permissão e admin
    */
    public static function permissao(Request $request){

        self::$verificaAdmin = true;

        $funcao = "processar".$request->method();
        $countRegistro = self::$funcao($request);
        
        return $countRegistro;
    }

    /**
     * valida acesso pra requisições POST
    */
    public static function processarPOST(Request $request){
        $params = $request->all();

        if( !isset($params['usuario']) || empty($params['usuario']) || !isset($params['senha']) || empty($params['senha']) ){
            return 0;
        }

        $return = self::buscaDadosAcesso($params['usuario'],$params['senha']);
        return $return;
    }

    /**
     * valida acesso pra requisições PUT
    */
    public static function processarPUT(Request $request){
        $params = $request->input();
        
        if( !isset($params['usuario']) || empty($params['usuario']) || !isset($params['senha']) || empty($params['senha']) ){
            return 0;
        }

        $return = self::buscaDadosAcesso($params['usuario'],$params['senha']);
        return $return;
    }

    /**
     * valida acesso pra requisições GET
    */
    public static function processarGET(Request $request){
        
        if( !isset($request->usuario) || empty($request->usuario) || !isset($request->senha) || empty($request->senha) ){
            return 0;
        }

        $return = self::buscaDadosAcesso($request->usuario,$request->senha);
        return $return;
    }

    /**
     * função isolada pra buscar os dados de acesso no banco
    */
    public static function buscaDadosAcesso($usuario,$senha){
        
        //inicia busca
        $dados = DB::table('usuario')
            ->select()
            ->where('nmUsuario',$usuario)
            ->where('dsSenha',sha1( env('KEY_APP_API') . $senha ) );

        //verifica se é pra conferir permissao de admin
        if( self::$verificaAdmin ){
            $dados = $dados->where('cdPermissao',1);
        }

        //finaliza busca e trabalha retorno
        $dados = $dados->get();

        $return = ['msg'=>'Erro ao autenticar...','registros'=>count($dados)];

        if( count($dados) && $dados[0]->confirmado == 0 ){
            $return = ['msg'=>'Usuário ainda não confirmado...','registros'=>0];
        }else if(count($dados) && $dados[0]->confirmado != 0){
            $return = ['msg'=>'Usuário autenticado...','registros'=>count($dados)];
        }else{
            $return = ['msg'=>'Permissão Negada...','registros'=>0];
        }

        return $return;
    }

    /**
     * recebe uma requisição GET, vinda provavelmente de um click em link
     * no email do usuário e valida se esse é um usuário, se for, altera o 
     * campo confirmado para 1
    */
    public static function confirmarUsuario(Request $request){

        //verifica se tem os parametros necessários
        if( !isset($request->usuario) || empty($request->usuario) || !isset($request->senha) || empty($request->senha) || !isset($request->senha) || empty($request->senha) ){
            return 0;
        }
        
    }

}