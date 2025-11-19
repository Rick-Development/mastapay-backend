<?php

namespace App\Http\Helpers\Payscribe\CardIssusing;

use App\Http\Helpers\ConnectionHelper;

class FreezeCardHelper extends ConnectionHelper {
    public function __construct(){
        parent::__construct();
    }

    public function freezeCard($data){
        $url = "/cards/".$data['card_id']."/freeze";
        
        return $this->post($url,$data); /// could be put or patch

    }

}