<?php

namespace App\Http\Controllers;

use App\Model\Bid;
use Illuminate\Http\Request;

class BidsController extends Controller
{
    public function create(Request $request)
    {
        return response()->json($request->all());
        $result = Bid::createFromRequest($request);
        return response()->json($result->message, $result->code);
    }
}
