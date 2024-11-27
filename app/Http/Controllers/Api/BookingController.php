<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BookingController
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => [
                'required',
                Rule::exists('rooms', 'id')
            ],
            'date' => 'required|date|after_or_equal:today',
            'bookingperiod_id' => [
                'required',
                Rule::exists('bookingperiods', 'id')
            ]
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $booking = new Booking;
        $booking->user_id = auth('api')->user()->id;
        $booking->room_id = $request->room_id;
        $booking->date = $request->date;
        $booking->bookingperiod_id = $request->bookingperiod_id;

        if($booking->isAlreadyBooked()) {
            return response()->json(["room_id" => ["Room already booked!"]], 422);
        }

        if($booking->save()){
            return response()->json([
                'success' => true,
                'booking' => $booking,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
}
