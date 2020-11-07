<?php

namespace App\Model;

use App\Events\NewBidSubmitted;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $primary_key = 'id';
    protected $table = 'bids';
    protected $with = 'user';

    public static function createFromRequest($request)
    {
        $result = new \stdClass();
        $item = Item::find((int)$request['itemId']);
        $lastBid = $item->getLastBid();
        if($lastBid && $lastBid->amount + $lastBid->auto_bidded_amount >= $request['amount']) 
        {
            $result->message = "Your bid needs to be higher than the latest";
            $result->code = 406;
            return $result;
        }

        if($lastBid && $lastBid->user_id == $request['userId'])
        {
            $result->message = "You already are the top bidder for this item";
            $result->code = 406;
            return $result;
        }

        $bid = new Bid();
        $bid->item_id = $request['itemId'];
        $bid->amount = $request['amount'];
        $bid->user_id = $request['userId'];
        $bid->enable_auto_bid = $request['enableAutoBid'];
        $bid->auto_bidded = false;
    
        event(new NewBidSubmitted($bid));

        $bid->save();

        $result->message = 'Bidded correctly';
        $result->code = 200;
        return $result; 
    }

    public static function createFromAutoBidding($userId, $itemId, $amount, $autoBidAmout)
    {
        $newBidPlace = new Bid();
        $newBidPlace->item_id = $itemId;
        $newBidPlace->user_id = $userId;
        $newBidPlace->amount = $amount;
        $newBidPlace->auto_bidded = true;
        $newBidPlace->auto_bidded_amount = $autoBidAmout;
        $newBidPlace->enable_auto_bid = true;
        $newBidPlace->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
