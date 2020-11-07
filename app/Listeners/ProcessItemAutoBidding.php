<?php

namespace App\Listeners;

use App\Events\NewBidSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessItemAutoBidding
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewBidSubmitted $event)
    {
        $event->bid->item->processAutoBidding($event->bid);
        return true;
    }
}
