<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    # exclude from response
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['wallet'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # get all tickets listed by a user
    public function tickets() {
        return $this->hasMany(ticket::class);
    }

    # get all purchase tickets
    public function usertickets() {
        return $this->hasMany(UserTicket::class);
    }

    # get all reviews belonging to a user
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    # get a wallet belonging to a user
    public function wallet() {
        return $this->hasOne(Wallet::class);
    }

    # get all likes belonging to a user
    public function likes() {
        return $this->hasMany(Like::class);
    }

    # get all trx belonging to a user
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

}
