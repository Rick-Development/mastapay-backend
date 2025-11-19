<?php

namespace Modules\BillPayment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BillPayment\Services\BaseVtpassService;
use App\Traits\ApiResponse; // Import the trait

class VtpassController extends Controller
{
    use ApiResponse;
    protected $baseVtpassService;

    public function __construct(
        BaseVtpassService $baseVtpassService
    ) {
        $this->baseVtpassService = $baseVtpassService;
    }

    protected function checkUserBalance($amount){
        $user = auth() -> user();
        if((float) $user->account_balance < (float) $amount){
            return false;
        }
        return true;
        // account_balance
    }
    public function categories()
    {
        return response()->json($this->baseVtpassService->getCategories());
    }

    public function services($identifier)
    {
        return response()->json($this->baseVtpassService->getServices($identifier));
    }

    public function variations($serviceId)
    {
        return response()->json($this->baseVtpassService->getVariations($serviceId));
    }

    public function options($serviceId, $optionName)
    {
        return response()->json($this->baseVtpassService->getOptions($serviceId, $optionName));
    }

    public function purchase(Request $request)
    {
        $amount  = $request->amount;
        if(!$amount){
            return [
                    "code" => "011",
                    "response_description"=> "INVALID ARGUMENTS",
                    "content" => [
                        "errors" => [
                            "amount is empty"
                        ]
            ]
                ];
        }
        // return $request -> user();
        $hasSufficientBalance = $this-> checkUserBalance($amount);
        if(!$hasSufficientBalance){
            return [
                    "code" => "021",
                    "response_description" => "INSUFFICIENT BALANCE",
                    "content" => [
                        "errors" => [
                            "User does not have sufficient balance to caryout the transaction"
                        ]
            ]
                ];
        }
        return response()->json($this->baseVtpassService->purchase($request->all()));
    }

    public function requery(Request $request)
    {
        return response()->json($this->baseVtpassService->requery($request->input('request_id')));
    }

    public function balance()
    {
        return response()->json($this->baseVtpassService->balance());
    }
}
