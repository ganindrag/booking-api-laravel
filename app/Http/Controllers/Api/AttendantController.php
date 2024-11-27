<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendant;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AttendantController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => [
                'required',
                Rule::exists('bookings', 'id')
            ],
            'user_ids' => 'required|array',
        ]);

        $validator->after(function($validator) {
            $validatorData = $validator->getData();
            if(!Booking::isBookerRight(auth('api')->user()->id, $validatorData['booking_id'])) {
                $validator->errors()->add('booking_id', "cannot assign attendants to another book!");
            }
            foreach($validatorData['user_ids'] as $user_id) {
                if(!User::find($user_id)) {
                    $validator->errors()->add('user_ids', "User ID $user_id not existed!");
                }
            }
        });

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        foreach($request->user_ids as $user_id) {
            $attendant = new Attendant;
            $attendant->booking_id = $request->booking_id;
            $attendant->user_id = $user_id;
            if(!$attendant->alreadyExists()){
                $attendant->save();
            }
        }

        return response()->json([
            'success' => true,
        ], 201);
    }
}
