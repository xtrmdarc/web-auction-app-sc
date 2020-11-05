<?php

namespace App\Http\Controllers;

use App\Model\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        return response()->json(Item::getAllActive(), 200);
    }

    public function show(Request $request)
    {   
        return response()->json(Item::showItemDetail($request['itemId']), 200);
    }
}
