<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillingResource;
use App\Models\Billing;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function total()
    {
        $total = Billing::where(['transporter_id' => auth()->user()->id])->sum('amount');
        return response()->json(['total' => $total]);
    }

    public function index()
    {
        $billing = Billing::where(['date' => Carbon::today()->format('Y-m-d')])->get();
        return response()->json(BillingResource::collection($billing));
    }
}
