<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function booking(){
        return $this->belongsTo(Bookings::class);
    }

    public function food(){
        return $this->belongsTo(RatingsFoods::class,'id','rating_id');
    }

    public function room(){
        return $this->belongsTo(RatingsRooms::class,'id','rating_id');
    }

    public function pool(){
        return $this->belongsTo(RatingsPools::class,'id','rating_id');
    }

    public function staff(){
        return $this->belongsTo(RatingsStaffs::class,'id','rating_id');
    }

    public function comment(){
        return $this->belongsTo(RatingsComments::class,'id','rating_id');
    }
}
