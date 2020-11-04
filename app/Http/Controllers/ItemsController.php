<?php

namespace App\Http\Controllers;

use App\Model\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        return Item::active()->get();
    }

    public function show(Request $request)
    {   
        $item = Item::find($request['itemId']);
        return response()->json(['item' => $item, 'lastBid' => $item->getLastBid()], 200);
    }
}
