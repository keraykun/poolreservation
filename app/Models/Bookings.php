<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
