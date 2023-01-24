<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\UserTripGood;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function trips()
    {
        $trips = Trip::all();
        return response()->json(TripResource::collection($trips), 200);
    }

    public function store(Request $request)
    {
        $array = $request->validate(
            [
                'from' => 'required|integer',
                'to' => 'required|integer',
                'goods' => 'required|array',
            ]
        );

        DB::beginTransaction();
        try {

            $array['transporter_id'] = auth()->user()->id;
            $array['date'] = Carbon::today()->format('Y-m-d');
            $trip = Trip::create($array);

            if (array_key_exists('goods', $array))
            {
                if (!empty($array['goods']))
                {
                    $trip_id = $trip->id;
                    $goodsArray = array_map(function ($item) use ($trip_id) {
                        $array['trip_id'] = $trip_id;
                        $array['transporter_id'] = auth()->user()->id;
                        $array['name'] = $item;
                        return $array;
                    }, $array['goods']);
                    UserTripGood::insert($goodsArray);
                }
            }

            DB::commit();
            return response()->json(new TripResource($trip), 200);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return response()->json($throwable, 400);
        }
    }
}
