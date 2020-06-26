<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta as RESP;
use App\Http\Repositories\Acesso\Acesso;
use DB;

class Home{

    private $resposta;

    public function __construct(){
        $this->resposta = new RESP();
    }

    public function index(Request $request){    
        return $this->resposta->send($request->all());
    }

    public function documentacao(){
        return view('doc.index');
    }

    public function getToken(Request $request){
        $dados = Acesso::getDadosToken($request);
    
        return view('doc.token')->with([
            'data'=>[
                'dadosToken'=>$dados
            ]
        ]);
    }

    public function showToken(){
        return view('doc.token');
    }

    public function erroRota(){
        return $this->resposta->erroRota();
    }

}