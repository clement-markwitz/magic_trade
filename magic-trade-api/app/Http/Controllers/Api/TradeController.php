<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Trade;
use Auth;
use DB;
use Illuminate\Http\Request;

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
            'trade'=>$trade->fresh()->items
            ],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([  
                'error'=> $e->getMessage()
                ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
