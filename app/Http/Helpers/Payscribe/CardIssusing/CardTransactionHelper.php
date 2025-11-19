<?php

namespace App\Http\Helpers\Payscribe\CardIssusing;

use App\Http\Helpers\ConnectionHelper;
use Carbon\Carbon;

class CardTransactionHelper extends ConnectionHelper {
    private $currentDate;

    public function __construct(){
        parent::__construct();
        $this->currentDate = date('Y-m-d'); // Current date
    }

    public function cardTransaction($cardId, $startDate, $endDate = null, $page){

        // if($endDate == null){
        //     $endDate  = $this->currentDate;
        // }
        $url = "/cards/transaction/$cardId/transactions?start_date=$startDate&end_date=$endDate&page_size=20&page=$page";
        // \Log::info($url);
        return $this->get($url);

    }

}