<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    protected $primary_key = 'id';
    protected $table = 'items';

    public function bids()
    {
        return $this->hasMany(Bid::class, 'item_id');
    }

    public function getLastBid()
    {   
        $lastBid = $this->bids()->orderBy(DB::raw('amount + auto_bidded_amount'), 'desc')->first();
        if(!$lastBid) 
        {
            $lastBid = new Bid();
            $lastBid->item_id = $this->id;
            $lastBid->amount = 0.00;
            $lastBid->auto_bidded_amount = 0.00;
        }
        return $lastBid;
    }

    public function scopeActive($query)
    {
        return $query->whereDate('end_date', '>', now());
    }

    public static function getAllActive()
    {
        $items = Item::active()->get();
        $items->map(function($item){
            $item->lastBid = $item->getLastBid();
        });
        return $items;
    }

    public static function showItemDetail($itemId)
    {
        $item = Item::find($itemId)->load(['bids' => function($query) {
            return $query->orderBy(DB::raw('amount + auto_bidded_amount'), 'desc');
        }]);
        $item->lastBid = $item->getLastBid();
        return $item;
    }

    public function processAutoBidding($newBid)
    {
        $highestBid = $this->getLastBid();
        if(!$highestBid->enable_auto_bid) return;
        if($highestBid->user->getAutoBiddingBalance() < 1) return;

        $currentBidderCompeteAmount = $newBid->amount + ($newBid->enable_auto_bid ? $newBid->user->getAutoBiddingBalance() : 0);
        $highestBidderCompeteAmount = $highestBid->amount + $highestBid->auto_bidded_amount +  $highestBid->user->getAutoBiddingBalance();

        if($currentBidderCompeteAmount > $highestBidderCompeteAmount + 1 )
        {
            if (!$newBid->enable_auto_bid ) return;
            Bid::createFromAutoBidding($newBid->user->id, $this->id, $newBid->amount, ($highestBidderCompeteAmount + 1 - $newBid->amount));
            return;
        }
        else 
        {
            Bid::createFromAutoBidding($highestBid->user->id, $this->id, $highestBid->amount, ($currentBidderCompeteAmount + 1 - $highestBid->amount));
            return;
        }
    }
}
