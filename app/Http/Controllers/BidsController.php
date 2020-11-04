<?php

namespace App\Http\Controllers;

use App\Model\Bid;
use Illuminate\Http\Request;

class BidsController extends Controller
{
    public function create(Request $request)
    {
       Bid::createFromRequest($request);
    }
}
