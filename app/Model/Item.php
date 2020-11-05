<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
        return $this->bids()->orderBy('created_at', 'desc')->first();
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
        $item = Item::find($itemId)->load('bids.user');
        $item->lastBid = $item->getLastBid();
        return $item;
    }
}
