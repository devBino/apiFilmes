<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Resposta\Resposta;
use App\Http\Repositories\Dados\CRUD as CD;
use DB;

class Elenco{

    private $resposta;

    public function __construct(){
        $this->resposta = new Resposta();
    }

    public function listar(Request $request){
        
        //busca os atores por filme
        $dados = DB::table('elenco as e')
            ->select(
                'e.id as idElenco',
                'a.id as idAtor',
                'a.nome as nomeAtor',
                'a.linkPublico as linkAtor',
                'd.id as idDiretor',
                'd.nome as nomeDiretor',
                'd.linkPublico as linkDiretor',
                'f.id as idFilme',
                'f.nome as nomeFilme',
                'f.dtLancamento',
                'f.classificacao',
                'f.genero',
                'f.duracao',
                'f.qtdeOscar',
                'f.resumo',
                'f.urlTrailer as '
            )
            ->join('filme as f','e.idFilme','=','f.id')
            ->join('ator as a','e.idAtor','=','a.id')
            ->join('diretor as d','f.idDiretor','=','d.id');
        
        //verifica parametro(s)
        if( isset($request->id) ){
            $dados = $dados->where('idFilme',$request->id);
        }

        $dados = $dados->orderBy('idFilme','asc')->get();
        
        if( !count($dados) ){
            return $this->resposta->processadoSemResposta();
        }

        //limpa o array
        $arrResponse = [];

        for( $i=0;$i<count($dados); $i++ ){
            $arrResponse[$dados[$i]->idFilme][] = $dados[$i];
        }

        //responde com os dados da busca
        return $this->resposta->send( (array) $arrResponse);
    }

    public function salvar(Request $request){
        
        $params = $request->all();


        //verifica se ator e filme já não estão vinculados
        $dadosVinculo = DB::table('elenco')->select()->where('idFilme',$params['filme'])->where('idAtor',$params['ator'])->get();

        if( count($dadosVinculo) ){
            return $this->resposta->processadoSemResposta();
        }

        //salva vinculo
        $acao = CD::salvar([
            'tabela'=>'elenco',
            'dados'=>[
                'idFilme'=>$params['filme'],
                'idAtor'=>$params['ator']
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
            'tabela'=>'elenco',
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