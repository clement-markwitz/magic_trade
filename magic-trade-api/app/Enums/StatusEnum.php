<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    
    /**
     * Obtenir toutes les valeurs possibles
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    /**
     * Vérifier si le statut est terminal (plus de modifications possibles)
     */
    public function isTerminal(): bool
    {
        return in_array($this, [
            self::COMPLETED,
            self::REJECTED,
            self::CANCELLED,
        ]);
    }
    
    /**
     * Obtenir une couleur CSS pour l'affichage
     */
    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'blue',
            self::ACCEPTED => 'yellow',
            self::COMPLETED => 'green',
            self::REJECTED, self::CANCELLED => 'red',
        };
    }
}