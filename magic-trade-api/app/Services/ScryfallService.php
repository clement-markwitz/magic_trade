<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
class ScryfallService
{
    protected $baseUrl = 'https://api.scryfall.com';
    
    /**
     * Récupère une carte par son ID Scryfall
     */
    public function getCardById(string $scryfallId)
    {
        return Cache::remember("scryfall_card_{$scryfallId}",3600,function () use ($scryfallId) {
            try {
                $response = Http::get("{$this->baseUrl}/cards/{$scryfallId}");
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            } catch (RequestException $e) {
                \Log::error('Erreur lors de la récupération de la carte Scryfall', [
                    'id' => $scryfallId,
                    'error' => $e->getMessage()
                ]);
                
                return null;
            }
        });
    }
    
    /**
     * Récupère une carte par son URI Scryfall
     */
    public function getCardByUri(string $uri)
    {
        return Cache::remember("scryfall_card_{$uri}",3600,function () use ($uri) {
            try {
                $response = Http::get($uri);
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            } catch (RequestException $e) {
                \Log::error('Erreur lors de la récupération de la carte Scryfall par URI', [
                    'uri' => $uri,
                    'error' => $e->getMessage()
                ]);
                
                return null;
            }
        });
    }
    
    /**
     * Recherche des cartes par nom
     */
    public function searchCards(string $query, array $params = [])
    {
         $cacheKey = "scryfall_search_" . md5($query . '_' . serialize($params));
        return Cache::remember("scryfall_card_{$cacheKey}",3600,function () use ($query, $params) {
            try {
                $response = Http::get("{$this->baseUrl}/cards/search", array_merge([
                    'q' => $query
                ], $params));
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            } catch (RequestException $e) {
                \Log::error('Erreur lors de la recherche de cartes Scryfall', [
                    'query' => $query,
                    'error' => $e->getMessage()
                ]);
                
                return null;
            }
        });
    }
    /**
     * Donne une carte aléatoirement 
     * @param string $query pour rechercher aléatoirment avec se nom
     */
    public function randomCards(string $query){
        try {
            if (empty($query)) {
                 $response=Http::get("{$this->baseUrl}/cards/random");
                 if ($response->successful()) 
                    return $response->json();
            }
            $response=Http::get("{$this->baseUrl}/cards/random",array_merge(['q'=> $query]));
            if ($response->successful())
                return $response->json();
            return null;
        } catch (RequestException $e) {
            \Log::error('Erreur lors de la recherche de cartes Scryfall', [
                'query'=>$query,
                'error'=> $e->getMessage()
            ]);
            return null;
        }
    }
}