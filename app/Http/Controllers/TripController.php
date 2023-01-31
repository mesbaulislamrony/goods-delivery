<?php

namespace App\Http\Controllers;

use App\Events\TripOrder;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\UserTripGood;
use Bschmitt\Amqp\Amqp;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        try {
            $array['transporter_id'] = auth()->user()->id;
            $array['date'] = Carbon::today()->format('Y-m-d');
            $array['status'] = 'waiting';
            $array['amount'] = rand(100, 999);
            $trip = Trip::create($array);
            $trip_id = $trip->id;

            if (array_key_exists('goods', $array)) {
                if (!empty($array['goods'])) {
                    $goodsArray = array_map(
                        function ($item) use ($trip_id) {
                            $array['trip_id'] = $trip_id;
                            $array['transporter_id'] = auth()->user()->id;
                            $array['name'] = $item;
                            return $array;
                        },
                        $array['goods']
                    );
                    UserTripGood::insert($goodsArray);
                }
            }

            $trip = Trip::with('transporter', 'goods')->find($trip_id);

            /*
             * Laravel Queue
             * */
            // SendTripMail::dispatch(json_encode($trip))->onQueue('send-trip-mail-everyone');

            /*
             * Rabbit MQ Queue
             * */
            // Amqp::publish('routing-key', json_encode($trip), ['queue' => 'send-trip-mail-everyone']);

            /*
             * Laravel Event
             * */

            event(new TripOrder(json_encode($trip)));

            return response()->json(new TripResource($trip), 200);
        } catch (\Throwable $throwable) {
            dd($throwable);
            return response()->json($throwable, 400);
        }
    }

    public function accept($id)
    {
        try {
            Trip::find($id)->update(['status' => 'accept']);
            return response()->json('Thank you for accepting offer', 200);
        } catch (\Throwable $throwable) {
            return response()->json($throwable, 400);
        }
    }

    public function notification()
    {
    }
}
