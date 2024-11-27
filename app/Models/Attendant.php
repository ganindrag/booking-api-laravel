<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    protected $table = 'attendants';
    public $timestamps = false;

    public function alreadyExists() {
        return $this->where('booking_id', $this->booking_id)->where('user_id', $this->user_id)->exists();
    }
}
