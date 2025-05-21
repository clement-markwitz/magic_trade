<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\UserCard;
use App\Services\ScryfallService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CardController extends Controller
{
    protected $scryfallService ;

    public function __construct(ScryfallService $scryfallService){
        $this->scryfallService = $scryfallService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Card::query();
        if($request->has('trade')){
            $query = $query->whereHas('userCard', function ($q) use ($request) {
            $q->where('trade', $request->trade);
        });
        }
        $cards = $query->get();
        return response()->json($cards);
    }

    /**
     * Creer et ajoute une carte au user
     */
    public function store(Request $request,bool $isInApi=true)
    {
        $request->validate([
            'scryfall_id'=>['required','string'],
            'finish'=>['required','string'],
            'etat'=>['required','string'],
            'acquired_date'=>['date'],
            'notes'=>['string']
            
        ],[
            'scryfall_id'=>'erreur avec le scryfall_id',
            'finish'=>'le finish est obligatoire',
            'etat'=>'l\'état est obligatoire'
        ]);
        if (!Card::where('id', $request->scryfall_id)->exists()) {

            $cardApi=$this->scryfallService->getCardById($request->scryfall_id);
            if(!$cardApi){
                return response()->json([
                    'error'=>"carte non trouvé"] ,404);
            }
            $card = Card::create([
                'id'=>$cardApi['id'],
                'name'=>$cardApi['name'],
                'language'=>$cardApi['lang'] ?? null,
                'set_code'=>$cardApi['set_id'],
                'collector_number'=>$cardApi['collector_number'],
                'rarity'=>$cardApi['rarity'],
                'image_uri'=>$cardApi['image_uris']['normal'] ?? null,
                'oracle_text'=>$cardApi['oracle_text'] ?? null,
                'type_line'=>$cardApi['type_line'] ?? null,
                'mana_cost'=>$cardApi['mana_cost'] ?? null,
                'cmc'=> $cardApi['cmc'] ?? null,
                'legalities'=> $cardApi['legalities'],
                'is_foil_available'=>$cardApi['foil'],
                'is_nonfoil_available'=>$cardApi['nonfoil'],
                'price_usd'=>$cardApi['price']['usd'] ?? null,
                'price_usd_foil'=>$cardApi['price']['usd_foil'] ?? null,
                'price_eur'=>$cardApi['price']['eur'] ?? null,
                'price_eur_foil'=>$cardApi['price']['eur_foil'] ?? null,
                'is_textless'=>$cardApi['textless'],
                'is_full_art'=>$cardApi['full_art'],
                'border_color'=>$cardApi['border_color'] ?? null,
                'artist'=> $cardApi['artist'] ?? null,
            ]);
        }else{
            $card=Card::where('id', $request->scryfall_id)->first();
    
        }
        

        $existingCard = UserCard::where([
            'user_id' => Auth::id(),
            'card_id' => $request->scryfall_id,
            'finish' => $request->finish,
            'etat'=>$request->etat
        ])->first();

        if ($existingCard) {
            $existingCard->quantity = $existingCard->quantity+1;
            $existingCard->save();
            $user_card=$existingCard;
        } else {

            $user_card=UserCard::create([
                'user_id'=>Auth::user()->id,
                'card_id'=>$request->scryfall_id,
                'image'=>$card->image_uri,
                'finish'=>$request->finish,
                'etat'=>$request->etat,
                'acquired_date'=>$request->acquired_date ?? null,
                'notes'=>$request->notes ?? null
            ]);
        }
        return response()->json([
            'message'=>"carte ajouté avec succés",
            'user_card'=>$user_card,
            'carte'=>$card ?? Card::where('id', $request->scryfall_id)->get(),
        ]);
        //TODO traiter le cas ou la carte n'existe pas et aussi le cas ou 

    }
    public function show($id){
        $card = Card::find($id);
        return response()->json([
            'message'=> 'carte trouvée',
            'card'=>$card]);
        }
    public function myCards(){
        $userCards = UserCard::where('user_id', Auth::id())->get();
        $cardIds = $userCards->pluck('card_id');
        $cards = Card::whereIn('id', $cardIds)->get();
        return response()->json([
            'cards'=> $cards
            ]);
    }
    /**
     * Display the specified resource.
     */
    public function showByUserCard(int $id)
    {
        $userCard=UserCard::findOrFail($id);
        $card=Card::where('id',$userCard->card_id )->first();
        return response()->json([
            'message'=> 'carte trouve',
            'card'=>$card]);
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
