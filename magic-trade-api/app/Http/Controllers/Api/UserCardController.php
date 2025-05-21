<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCard;
class UserCardController extends Controller
{
    public function index(Request $request){
        $userCards = UserCard::all();
        return response()->json($userCards);
        //TODO ajouter filtre
    }
    public function store(Request $request){
        //TODO a faire peu etre pour le admin
    }
    public function showByCardAndUserId(int $cardId,int $userId){
        $userCard = UserCard::where('user_id', $userId)->where('card_id', $cardId)->first();
        if($userCard)
            return response()->json(['error'=>'carte non trouvée']);
        return response()->json($userCard);
    }
    public function show(int $id){
        $userCard = UserCard::find($id)->first();
        if($userCard)
            return response()->json(['error'=>'carte non trouvée']);
        return response()->json($userCard);
    }
    public function update(Request $request, int $id){
        $userCard = UserCard::find($id);
        $userCard->update($request->all());
        return response()->json(['success'=> 'carte mise a jour','userCard'=>$userCard->fresh()]);
    }
    public function destroy(int $id){
        $userCard = UserCard::find($id);
        $userCard->delete();
        return response()->json(['success'=> 'carte supprimer de l`\'invetaire']);
    }
}