<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "clients";
    protected $fillable = [ 
        'user_id','name','last_name','pseudo','contry','city','street','postal_code','phone','description'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
