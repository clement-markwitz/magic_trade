<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    protected $table = "user_cards";
    protected $fillable = [
        'user_id','card_id','finish','image','quantity','trade','etat','notes','acquired_date','notes'];
    protected $casts = [
        'trade'=>'boolean'
        ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function card() {
        return $this->belongsTo(Card::class);
    }
    public function tradeItems(){
        return $this->hasMany(TradeItem::class);
    }
    /**
     * permet de savoir si elle est dans un trade
     */
    public function haveTradeItem(){
        if ($this->tradeItems()->count() > 0){
            $this->trade=true;
            return true;
        }
        $this->trade=false;
        return false;
    }
    /**
     * return combien de trade a cette carte
     * @return int
     */
    public function ManyInTrade(){
        return $this->tradeItems()->count();
    }
    /**
     * Portée de requête pour les cartes disponibles à l'échange.
     */
    public function scopeForTrade($query):UserCard
    {
        return $query->where('trade', true);
    }
    /**
     * Portée de requête pour les cartes foil.
     */
    public function scopeFoil($query):UserCard
    {
        return $query->where('foil', true);
    }
    public function scopeByLanguage($query, $language):UserCard
    {
        return $query->where($this->card->language, $language);
    }
    /**
     * Obtenir la valeur estimée actuelle de cet élément de collection.
     */
    public function getCurrentValue()
    {
        $card = $this->card;
        
        if ($this->finish=='foil') {
            return $card->price_usd_foil ?? null;
        }
        return $card->price_usd;
        
    }
}
