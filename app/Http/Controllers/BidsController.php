<?php

namespace App\Http\Controllers;

use App\Model\Bid;
use Illuminate\Http\Request;

class BidsController extends Controller
{
    public function create(Request $request)
    {
        $result = Bid::createFromRequest($request);
        return response()->json(['message' => $result->message, 'code' => $result->code], $result->code);
    }
}
