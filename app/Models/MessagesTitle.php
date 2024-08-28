<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagesTitle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function client(){
        return $this->belongsTo(User::class,'to_user_id','id');
    }

    public function message()
    {
        return $this->hasMany(Messages::class,'messages_title_id','id');
    }

    public function booked()
    {
        return $this->hasMany(Bookings::class,'user_id','to_user_id');
    }

    // public function messagesto()
    // {
    //     return $this->hasMany(Messages::class, 'id', 'message_titles_id');
    // }


}
