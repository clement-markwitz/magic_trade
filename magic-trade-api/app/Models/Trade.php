<?php

namespace App\Models;

use App\Enums\StatusEnum;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'user_one',
        'user_two',
        'user_one_accept',
        'user_one_trades',
        'user_two_accept',
        'user_two_accept',
        'status',
        'completed_at'
    ];
    
    protected $casts = [
        'status' => StatusEnum::class,
        'user_one_accept'=>'boolean',
        'user_two_accept'=>'boolean',
        'user_one_trades'=>'boolean',
        'user_two_trades'=>'boolean',
        'completed_at' => 'datetime'
    ];
    
    // Relations
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one');
    }
    
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two');
    }
    
    public function items()
    {
        return $this->hasMany(TradeItem::class);
    }
    
    // Méthodes utiles avec les enums
    public function isPending(): bool
    {
        return $this->status === StatusEnum::PENDING;
    }
    
    public function isCompleted(): bool
    {
        return $this->status === StatusEnum::COMPLETED;
    }
    
    public function canBeCancelled(): bool
    {
        return !$this->status->isTerminal();
    }
    public function cancel($id){
        $isUserOne = ($this->user_one == $id);
        $tradeAttribute = $isUserOne ? 'user_one_trades' : 'user_two_trades';
        $acceptAttribute = $isUserOne ? 'user_one_accept' : 'user_two_accept';
        
        if ($this->$tradeAttribute == true) {
            $this->$tradeAttribute = false;
            $this->status = StatusEnum::ACCEPTED->value;
        } else {
            $this->$acceptAttribute = false;
            $this->status = StatusEnum::PROGRESS->value;
        }
        $this->save();

    }
    
    
    // Méthode pour rejeter un échange
    public function reject(): void
    {
        if (!$this->isPending()) {
            throw new \Exception("Seuls les échanges en attente peuvent être rejetés");
        }
        
        $this->status = StatusEnum::REJECTED;
        $this->save();
    }
}