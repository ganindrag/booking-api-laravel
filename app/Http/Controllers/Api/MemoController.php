<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemoController
{
    /**
     * Handle the incoming request.
     */
    public function put(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => [
                'required',
                Rule::exists('bookings', 'id')
            ],
            'memo' => 'required|string',
        ]);

        $validator->after(function($validator) {
            $validatorData = $validator->getData();
            if(!Booking::isBookerRight(auth('api')->user()->id, $validatorData['booking_id'])) {
                $validator->errors()->add('booking_id', "cannot set memo to another book!");
            }
        });

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $booking = Booking::find($request->booking_id);
        $booking->memo = $request->memo;

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

    public function get($booking_id) {
        $booking = Booking::join('attendants', 'booking_id', '=', 'bookings.id')
            ->where('booking_id', '=', $booking_id)
            ->where(function($query) {
                $query->where('attendants.user_id', '=', auth('api')->user()->id)
                    ->where('bookings.user_id', '=', auth('api')->user()->id, 'or');
            })
            ->first();

        if(!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'memo' => $booking->memo
        ], 200);
    }
}
