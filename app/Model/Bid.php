<?php

namespace App\Model;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $primary_key = 'id';
    protected $table = 'bids';

    public static function createFromRequest($request)
    {
        $result = new \stdClass();
        $item = Item::find((int)$request['itemId']);
        $lastBid = $item->getLastBid();
        if($lastBid && $lastBid->amount > $request['amount']) 
        {
            $result->message = "Bid amount can't be lower than maximun";
            $result->code = 406;
            return $result;
        }
        
        if($lastBid && $lastBid->userId == $request['userId'])
        {
            $result->message = "You already are the top bidder for this item";
            $result->code = 406;
            return $result;
        }

        $bid = new Bid();
        $bid->item_id = $request['itemId'];
        $bid->amount = $request['amount'];
        $bid->date = now();
        $bid->user_id = $request['userId'];
        $bid->save();

        $result->message = 'Bidded correctly';
        $result->code = 200;
        return $result; 
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
