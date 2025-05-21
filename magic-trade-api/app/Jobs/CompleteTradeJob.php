<?php

namespace App\Jobs;

use App\Enums\StatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Trade;

class CompleteTradeJob implements ShouldQueue
{
    use Queueable,Dispatchable,SerializesModels,InteractsWithQueue;
    protected $tradeId;
    /**
     * Create a new job instance.
     */
    public function __construct($tradeId)
    {
        $this->tradeId = $tradeId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $trade = Trade::findOrFail($this->tradeId);
        if ($trade->status==StatusEnum::ACCEPTED->value) {
            $trade->status = StatusEnum::COMPLETED;
            $trade->save();
        }
    }
}
