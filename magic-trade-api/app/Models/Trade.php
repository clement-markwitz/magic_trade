<?php

namespace App\Models;

use App\Enums\StatusEnum;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'user_one',
        'user_two',
        'status',
        'completed_at'
    ];
    
    protected $casts = [
        'status' => StatusEnum::class,
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
    
    // Méthode pour compléter un échange
    public function complete(): void
    {
        if (!$this->isPending()) {
            throw new \Exception("Seuls les échanges en attente peuvent être complétés");
        }
        
        $this->status = StatusEnum::COMPLETED;
        $this->completed_at = now();
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