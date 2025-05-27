<?php

namespace App\Jobs;

use App\Enums\StatusEnum;
use App\Models\UserCard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Trade;
use Log;

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
        if($trade->status->value == StatusEnum::ACCEPTED->value) {
            $trade->status = StatusEnum::COMPLETED;
            $trade->save();
            $items=$trade->items;
            foreach($items as $item) {
                $userCard=$item->userCard;
                $existingCard = UserCard::where([
                    'user_id'=>$item->to_user_id,
                    'card_id'=>$userCard->card_id,
                    'finish'=>$userCard->finish,
                    'etat'=>$userCard->etat,
                ])->first();
                if ($existingCard) {
                    $existingCard->quantity = $existingCard->quantity+1;
                    $existingCard->save();
                }else{
                    UserCard::create([
                        'user_id'=>$item->to_user_id,
                        'card_id'=>$userCard->card_id,
                        'image'=>$userCard->image ?? null,
                        'finish'=>$userCard->finish,
                        'trade'=>true,
                        'etat'=>$userCard->etat,
                        'acquired_date'=>now(),
                        'notes'=>$userCard->notes ?? null,
                    ]);
                }
                $item->delete();
            }
        } else {
            Log::info("Status not changed because it's not ACCEPTED");
        }
    }
}
