<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Jobs\CompleteTradeJob;
use App\Models\Trade;
use App\Models\TradeItem;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Trade::query();   
        if($request->has('status')){
            $query->where('status', $request->status);
        } 
        $trades= $query->get();
        return response()->json($trades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $trade=Trade::create([
            'user_one'=>Auth::user()->id,
            'user_two'=>$request->user_two_id ?? null
        ]);
        return response()->json([
            'message'=>'trade creer',
            'trade'=>$trade
        ]);
    }
    public function myTrades(Request $request){
        $trades=Trade::where('user_one',Auth::user()->id)->orWhere('user_two',Auth::user()->id)->get();
        return response()->json($trades);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trade= Trade::findOrFail($id);
        return response()->json(['trade'=>$trade,
        'tradeItem'=>$trade->items ?? null]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $trade=Trade::findOrFail($id);

        if ($trade->user_one == Auth::id()) {
        return response()->json([
            'error' => 'Vous ne pouvez pas rejoindre votre propre offre d\'échange'
        ], 403);
        }
        if ($trade->user_two != null) {
        return response()->json([
            'error' => 'Cet échange a déjà été accepté par un autre utilisateur'
        ], 409);
        }
    
        DB::beginTransaction();
        try {
            $trade->update([
                'user_two'=>Auth::user()->id,
                'status'=>StatusEnum::PROGRESS->value
            ]);
            $item=$trade->items;
            for ($i= 0; $i < count($item); $i++) {
                $item[$i]->to_user_id=Auth::user()->id;
                $item[$i]->save();
            }
            DB::commit();
            return response()->json([
            'message'=> 'bien mise a jour ',
            'trade'=>$trade,
            'tradeItem'=>$trade->fresh()->items
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([  
                'error'=> $e->getMessage()
                ],400);
        }
    }
    public function leave(string $id){
        $trade=Trade::findOrFail($id);
        if (!$trade->status == StatusEnum::PROGRESS->value) {
            return response()->json([
                'error'=> 'le trade est deja accepté ou pas rejoin']);
        }
        DB::beginTransaction();
        try {
            $trade->update([
                'user_two'=>null,
                'status'=>StatusEnum::PENDING->value
                ]);
            $items=$trade->items;
            for ($i= 0; $i < count($items); $i++) {
                if($items[$i]->userCard->user_id==Auth::user()->id){
                    TradeItem::where('id',$items[$i]->id)->delete();
                }
                else{
                    $items[$i]->to_user_id=null;
                    $items[$i]->save();
                }
            }
            DB::commit();
            return response()->json([
                'message'=> 'trade quitté avec succes',
                'tradeItem'=>$trade->fresh()->items,
                'trade'=>$trade->fresh()]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'=> $e->getMessage()
                ],400);
        }
    }
    public function accept(string $id){
        $trade=Trade::findOrFail($id);
        if (!$trade->status == StatusEnum::PROGRESS->value) {
            return response()->json([
                'error'=> 'pas possible d\accepter']);
        }
        $user_id=Auth::user()->id;
        if($trade->user_one==$user_id){
            $trade->user_one_accept=true;
            $trade->save();
        }
        elseif($trade->user_two==$user_id){
            $trade->user_one=true;
            $trade->save();
        }
        else{
            return response()->json([
                'error'=> 'vous ne faites pas partie du trade'
            ]);
        }
        if($trade->fresh()->user_one_accept== true && $trade->user_two_accept==true){
            $trade->status=StatusEnum::ACCEPTED;
            $trade->completed_at=now();

            CompleteTradeJob::dispatch($trade->id)->delay(now()->addSeconds(10));
        }
        $trade->save();
        return response()->json([
            'status'=>$trade->status,
        'trade'=>$trade->fresh()]);
    }
    //TODO cancel trade
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
