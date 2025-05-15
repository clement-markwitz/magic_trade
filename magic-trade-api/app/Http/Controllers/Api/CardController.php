<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
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
    public function index()
    {
        $cards = Card::all();
        return response()->json($cards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,bool $isInApi=true)
    {
        $request->validate([
            'scryfall_id'=>['required','string']
        ],[
            'scryfall_id'=>'erreur avec le scryfall_id'
        ]);
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
            'image_uri'=>$cardApi['image_uri']['normal'] ?? null,
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
        return response()->json([
            'message'=>"carte ajouté avec succés",
            'carte'=>$card
        ]);
        //TODO traiter le cas ou la carte n'existe pas
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
