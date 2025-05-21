<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = "clients";
    protected $fillable = [ 
        'user_id','name','last_name','email','pseudo','contry','city','street','postal_code','phone','description'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
