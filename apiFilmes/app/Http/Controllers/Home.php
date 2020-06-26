<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta as RESP;

class Home{

    private $resposta;

    public function __construct(){
        $this->resposta = new RESP();
    }

    public function index(Request $request){    
        return $this->resposta->send($request->all());
    }

    public function documentacao(){

        return view('doc.index')->with([
            'data'=>[
                'url'=>env('API_DOC')
            ]
        ]);
    }

    public function erroRota(){
        return $this->resposta->erroRota();
    }

}