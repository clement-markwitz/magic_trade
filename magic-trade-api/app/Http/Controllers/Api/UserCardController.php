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
    /**
     * supprime une quantité de cette carte
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function removeOne(int $id){
        $userCard = UserCard::find($id);
        if ($userCard->quantity==0){
            return response()->json([
                'message'=> 'impossible de supprimer car plus d\'exemplaire'
                ]);
        }
        $userCard->quantity=$userCard->quantity-1;
        return response()->json([
            'message'=> 'une quantité supprimé']);
    }
    public function destroy(int $id){
        $userCard = UserCard::find($id);
        if( $userCard->trade==true){
            return response()->json([
                'message'=> 'la carte est en trade impossible de supprimer']);
        }
        $userCard->delete();
        return response()->json(['success'=> 'carte supprimer de l`\'invetaire']);
    }
}