<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Payscribe\CardIssusing\CardTransactionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PayscribeVirtualCardTransaction;


class PayscribeCardTransactionController extends Controller
{
    private $currentDate;

    public function __construct(private CardTransactionHelper $cardTransactionHelper){
        $this->currentDate = date('Y-m-d'); // Current date

    }

    public function createCardTransaction(Request $request)
{
    $data = $request->validate([
        'card_id'     => 'required|string',
        'start_date'  => 'sometimes|date',
        'end_date'    => 'sometimes|date',
        'page'        => 'sometimes|integer',
    ]);

    // Generate reference
    $data['ref'] = (string) Str::uuid();

    // Default values
    $cardId     = $data['card_id'];
    $startDate  = $data['start_date'] ?? '2025-11-01';
    $endDate    = $data['end_date'] ?? now()->toDateString();   // current date
    $page       = $data['page'] ?? 1;

    // Eloquent Query with filters
    $transactions = PayscribeVirtualCardTransaction::query()
        ->where('user_id', auth()->id())
        ->where('card_id', $cardId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->latest()
        ->paginate(10, ['*'], 'page', $page); // optional pagination

    return response()->json([
        // 'ref'          => $data['ref'],
        // 'filters_used' => compact('cardId', 'startDate', 'endDate', 'page'),
        'transactions' => $transactions,
    ], 200);
}


    // public function createCardTransaction(Request $request){
    //     $data = $request->validate(
    //         [
    //             'card_id' => 'required | string',
    //             'start_date' => 'sometimes | string',
    //             'end_date' => 'sometimes | string',
    //             'page' => 'sometimes | string',
    //         ]
    //     );
    //     // list($ref, $start_date, $end_date, $page) = $data;
    //     // ['ref' => $ref, 'start_date' => $start_data, 'end_date' => $end_data, 'page' => $page] = $data;
    //     $referenceId = Str::uuid();
    //     $referenceIdString = (string) $referenceId;
    //     $data = array_merge($data, ['ref' => $referenceIdString]);
        
    //     $cardId = $data['card_id'];
    //     $start_data = $data['start_data'] ?? '2025-11-01';
    //     $end_data = $data['end_data'] ?? $this->currentDate;
    //     $page = $data['page'] ?? 1;

    //     $transactions = PayscribeVirtualCardTransaction::where(['user_id' => auth()->user()->id, 'card_id' =>$data['card_id'] ]) ->get();
    //     // $response = json_decode($this->cardTransactionHelper->cardTransaction($cardId, $start_data, $end_data, $page), true);
    //     return response()->json([
    //         'transactions' => $transactions
    //     ], 200);
    // }


}