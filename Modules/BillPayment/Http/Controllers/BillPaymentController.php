<?php

namespace Modules\BillPayment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\BillPayment\Services\VtpassService;

class BillPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('billpayment::index');
    }


        public function process(Request $request, VtpassService $vtpass)
        {
            return $vtpass->payBill($request->all());
        }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('billpayment::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('billpayment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('billpayment::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
