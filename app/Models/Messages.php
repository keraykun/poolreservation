<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function messagetitle(){
    //     return $this->belongsTo(MessagesTitle::class,'id','to_user_id',);
    // }

    // public function messagetitle(){
    //     return $this->hasMany(MessagesTitle::class,'id','to_user_id');
    // }

    // public function messagesto()
    // {
    //     return $this->belongsTo(MessagesTitle::class, 'to_user_id', 'to_user_id');
    // }
}
