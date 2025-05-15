<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeItem extends Model
{
    protected $fillable = [
        'trade_id','user_card_id','to_user_id'
        ];
    public function trade(){
        return $this->belongsTo(Trade::class,'trade_id');
    }
    public function userCard(){
        return $this->belongsTo(UserCard::class,'user_id');
    }
    public function toUser(){
        return $this->belongsTo(User::class,'to_user_id');
    }
    public function fromUser(){
        return $this->userCard->user;
    }
}
