<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Activity; // Adjust this line

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }

    public function booking(){
        return $this->belongsTo(Bookings::class,'id','user_id');
    }

    public function bookinghistory(){
        return $this->belongsTo(BookingsHistory::class,'id','user_id');
    }

    public function warning(){
        return $this->hasMany(BookingsHistory::class);
    }

    public function messagetitle(){
        return $this->hasMany(MessagesTitle::class,'to_user_id','id');
    }

    public function messagetitlebelong(){
        return $this->belongsTo(MessagesTitle::class,'id','to_user_id');
    }

    public function messageto(){
        return $this->hasMany(Messages::class,'to_user_id','id');
    }

    public function getMessagesCountAttribute()
    {
        return $this->messageto->where('seen', 1)->count();
    }


}
