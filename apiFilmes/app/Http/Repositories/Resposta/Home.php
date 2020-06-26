<?php
namespace App\Http\Repositories\Resposta;

use App\Http\Interfaces\Resposta;

class Home implements Resposta{

    public function send(Array $params){
        return json_encode($params);
    }

}