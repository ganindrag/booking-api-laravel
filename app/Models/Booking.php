<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    public function isAlreadyBooked() {
        return $this->where('room_id', $this->room_id)
            ->where('date', $this->date)
            ->where('bookingperiod_id', $this->bookingperiod_id)
            ->exists();
    }

    public static function isBookerRight($user_id, $booking_id) {
        return self::where('user_id', $user_id)->where('id', $booking_id)->exists();
    }
}
