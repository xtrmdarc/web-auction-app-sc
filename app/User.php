<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Model\Bid;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'max_auto_bid_amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class, 'user_id');
    }

    public function getAutoBiddingBalance()
    {   
        $amountAutoBidded = $this->getWinningAuctions()->reduce(function($acc, $nextBid) {
            return $acc + $nextBid->auto_bidded_amount;
        },0);
        return $this->max_auto_bid_amount - $amountAutoBidded;
    }

    public function getWinningAuctions()
    {
        return $this->bids->filter(function($bid) {
            return $bid->id === $bid->item->getLastBid()->id;
        });
    }
}
