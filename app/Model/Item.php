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
        return $this->bids->order_by('created_at', 'desc')->first();
    }
}
