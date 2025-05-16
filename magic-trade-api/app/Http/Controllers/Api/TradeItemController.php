<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TradeItem;
use Illuminate\Http\Request;

class TradeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'trade_id'=>['required','int'],
            'user_card_id'=>['required','int'],
            'to_user_id'=>['int']
        ]);
        $item = TradeItem::create([
            'trade_id'=>$request->trade_id,
            'user_card_id'=>$request->user_card_id,
            'to_user_id'=>$request->to_user_id ?? null
        ]);
        return response()->json([
            'message'=>'carte ajoutée avec succes',
            'tradeItem'=>$item
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
