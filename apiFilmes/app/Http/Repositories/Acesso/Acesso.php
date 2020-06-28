<?php
namespace App\Http\Repositories\Acesso;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use DB;

class Acesso{

    private static $verificaAdmin = false;
    private static $usuario;
    private static $senha;
    private static $token;
    private static $permissao;

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

        if( !isset($params['usuario']) || empty($params['usuario']) || !isset($params['senha']) || empty($params['senha']) || !isset($params['token']) || empty($params['token']) ){
            return ['msg'=>'Erro ao autenticar...','registros'=>0];
        }

        self::$usuario  = $params['usuario'];
        self::$senha    = $params['senha'];
        self::$token    = $params['token'];

        $return = self::buscaDadosAcesso();
        return $return;
    }

    /**
     * valida acesso pra requisições PUT
    */
    public static function processarPUT(Request $request){
        $params = $request->input();
        
        if( !isset($params['usuario']) || empty($params['usuario']) || !isset($params['senha']) || empty($params['senha']) || !isset($params['token']) || empty($params['token']) ){
            return ['msg'=>'Erro ao autenticar...','registros'=>0];
        }

        self::$usuario  = $params['usuario'];
        self::$senha    = $params['senha'];
        self::$token    = $params['token'];

        $return = self::buscaDadosAcesso();
        return $return;
    }

    /**
     * valida acesso pra requisições GET
    */
    public static function processarGET(Request $request){
        
        if( !isset($request->usuario) || empty($request->usuario) || !isset($request->senha) || empty($request->senha) || !isset($request->token) || empty($request->token) ){
            return ['msg'=>'Erro ao autenticar...','registros'=>0];
        }

        self::$usuario  = $request->usuario;
        self::$senha    = $request->senha;
        self::$token    = $request->token;

        $return = self::buscaDadosAcesso();
        return $return;
    }

    /**
     * valida acesso pra requisições DELETE
    */
    public static function processarDELETE(Request $request){

        if( !isset($request->usuario) || empty($request->usuario) || !isset($request->senha) || empty($request->senha) || !isset($request->token) || empty($request->token) ){
            return ['msg'=>'Erro ao autenticar...','registros'=>0];
        }

        self::$usuario  = $request->usuario;
        self::$senha    = $request->senha;
        self::$token    = $request->token;

        $return = self::buscaDadosAcesso();
        return $return;
    }

    /**
     * Pesquisa os dados do usuário no banco de dados
     * essa função será chamada apenas se o usuário 
     * ainda não foi autenticado anteriormente
    */
    public static function validaUsuarioToken(){

        self::$permissao = 2;

        //verifica se é um usuário e se possui esse token
        $dadosToken = DB::table('usuario')
            ->select('tokenCompleto','tokenUsuario')
            ->where('nmUsuario',self::$usuario)
            ->get();

        if(!count($dadosToken)){
            return ['msg'=>'Usuário não localizado...','registros'=>0];
        }

        $tokenBanco = $dadosToken[0]->tokenUsuario;

        if( self::$token != $tokenBanco ){
            return ['msg'=>'Token de usuário inválido...','registros'=>0];
        }

        //inicia verifcação completa no banco
        $dados = DB::table('usuario')
            ->select()
            ->where('nmUsuario',self::$usuario)
            ->where('dsSenha',sha1( env('KEY_APP_API') . self::$senha ) )
            ->where('tokenCompleto',self::$token . env('KEY_APP_API') );

        //verifica se é pra conferir permissao de admin
        if( self::$verificaAdmin ){
            $dados = $dados->where('cdPermissao',1);
        }

        //finaliza busca e trata retorno
        $dados = $dados->get();

        $return = ['msg'=>'Erro ao autenticar...','registros'=>count($dados)];

        if( count($dados) && $dados[0]->confirmado == 0 ){
            $return = ['msg'=>'Usuário ainda não confirmado...','registros'=>0];
        }else if(count($dados) && $dados[0]->confirmado != 0){
            self::$permissao = $dados[0]->cdPermissao;
            $return = ['msg'=>'Usuário autenticado...','registros'=>count($dados)];
        }else{
            $return = ['msg'=>'Permissão Negada...','registros'=>0];
        }

        return $return;
    }

    /**
     * Seta a chave de autenticação no Rdis para evitar ficar buscando
     * no banco de dados em toda requisição
    */
    public static function setAutenticacaoRedis(){
        Redis::set(
            self::$usuario.self::$senha,
            serialize(['token'=>self::$token,'permissao'=>self::$permissao,'registros'=>1]),
            'EX',
            env('TEMPO_TOKEN_API')
        );
    }

    /**
     * Recupera autenticação no redis, a chave é o nome do usuário + a senha
    */
    public static function getAutenticacaoRedis(){
        return unserialize(Redis::get(self::$usuario.self::$senha));
    }

    /**
     * função isolada pra buscar os dados de acesso
     * por padrão a composição da senha no banco é sha1(env('KEY_APP_API').$senhaRecebida)
     * por padrão o tokenCompleto no banco é $tokenRecebido . env('KEY_APP_API')
     * onde
     * usuario,senha e token recebios estão setados como atributos dessa classe
    */
    public static function buscaDadosAcesso(){
        
        $dadosAuth = self::getAutenticacaoRedis();
        
        if( $dadosAuth && is_array($dadosAuth) ){
            if( self::$verificaAdmin ){

                if( $dadosAuth['permissao'] != 1 ){
                    return ['msg'=>'Permissao Negada...','registros'=>0];
                }else{
                    return ['msg'=>'Usuário autenticado...','registros'=>1];
                }

            }else{

                if( $dadosAuth['token'] == self::$token ){
                    return ['msg'=>'Usuário autenticado...','registros'=>1];
                }else{
                    return ['msg'=>'Token inválido...','registros'=>0];
                }
                
            }
            
        }else if( !$dadosAuth ){
            
            $arrAutenticacao = self::validaUsuarioToken();
            
            if($arrAutenticacao['registros'] == 0){
                return $arrAutenticacao;
            }else{
                self::setAutenticacaoRedis();
                return $arrAutenticacao;
            }
        }

    }

    /**
     * retorna dados do token do usuário atraves de usuario + email
     * @return array
    */
    public static function getDadosToken(Request $request){
        
        //inicia busca
        $dados = DB::table('usuario')
            ->select()
            ->where('nmUsuario',$request->usuario)
            ->where('email', base64_decode($request->email) )
            ->get();
        
        //retorna array vazio
        if( !count($dados) ){
            return [];
        }

        //retorna dados
        $return = [
            'usuario'=>$request->usuario,
            'email'=>$request->email,
            'token'=>$dados[0]->tokenUsuario
        ];

        return $return;
    }

}