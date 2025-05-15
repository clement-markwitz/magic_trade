<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * model of Card
 */
class Card extends Model
{
    protected $table = "cards";
     protected $fillable = [
        'id', 'name','language', 'set_code', 'collector_number', 'rarity',
        'image_uri', 'oracle_text', 'type_line', 'mana_cost',
        'cmc', 'legalities', 'is_foil_available',
        'is_nonfoil_available', 'price_usd',
        'price_usd_foil', 'price_eur', 'price_eur_foil',
        'is_textless', 'is_full_art', 'border_color', 'artist','last_updated'
    ];
     protected $casts = [
        'legalities' => 'array',
        'is_foil_available' => 'boolean',
        'is_nonfoil_available' => 'boolean',
        'has_etched_version' => 'boolean',
        'is_textless' => 'boolean',
        'is_full_art' => 'boolean',
        'last_updated'=>'date'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
     /**
      * la liaison des cartes et des cartes des utilisateurs
      * @return \Illuminate\Database\Eloquent\Relations\HasMany<UserCard, Card>
      */
     public function userCard()
    {
        return $this->hasMany(UserCard::class, 'card_id', 'id');
    }
}
