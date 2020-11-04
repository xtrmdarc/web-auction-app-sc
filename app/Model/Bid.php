<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $primary_key = 'id';
    protected $table = 'bids';

    public static function createFromRequest($request)
    {
        $result = new \stdClass();
        $item = Item::find($request['itemdId']);
        $lastBid = $item->getLastBid();
        if($lastBid && $lastBid->amount > $request['amount']) 
        {
            $result->message = "Bid amount can't be lower than maximun";
            $result->code = 406;
            return $result;
        }
        
        if($lastBid && $lastBid->user == $request['user'])
        {
            $result->message = "You already are the top bidder for this item";
            $result->code = 406;
            return $result;
        }

        $bid = new Bid();
        $bid->item_id = $request['itemdId'];
        $bid->amount = $request['amount'];
        $bid->date = now();
        $bid->user = $request['user'];
        $bid->save();

        $result->message = 'Bidded correctly';
        $result->code = 200;
        return $result; 
    }
}
