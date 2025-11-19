<?php

namespace App\Http\Helpers\Payscribe\CardIssusing;

use App\Http\Helpers\ConnectionHelper;

class CardDetailsHelper extends ConnectionHelper {
    public function __construct(){
        parent::__construct();
    }

    public function getCardDetails($data){
        $url = "/cards/{$data['card_id']}";
        
        return $this->get($url);

    }
}