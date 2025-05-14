<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientRessource;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>['required','string','max:50'],
            'last_name'=>['required','string','max:100'],
            'pseudo'=>['required','string','max:20','unique:clients,pseudo'],
            'contry'=>['required','string','max:50'],
            'city'=>['required','string','max:100'],
            'street'=>['string','max:100'],
            'postal_code'=>['required','string','digits:5'],
            'phone'=>['required','string','max:20'],
            'description'=>['string','max:1000'],
        ],[
            'name'=>'le prénom est obligatoire',
            'last_name'=>'le nom est obligatoire',
            'pseudo.required'=>'le pseudo est obligatoire',
            'pseudo.unique'=>'pseudo deja utilisé',
            'contry'=>'le pays est obligatoire',
            'city'=>'la ville est obligatoire',
            'postal_code'=>'le code postal est obligatoire',
            'phone'=>'le tel est obligatoire',
            'description'=> 'description trop longue (1000 caractères) '
        ]);
        $request->validate([
            'email'=>['required','string','unique:users','confirmed','email'],
            'password'=> ['required','string',Password::min(8)
        ->letters()
        ->mixedCase()
        ->numbers()
        ->symbols()
        ,'confirmed'],
        ],[
            'email.required'=>'email obligatoire',
            'email.email'=>'rentrez un format d\'email valide',
            'email.confirmed'=>'la confirmation de l\'email ne correspond pas',
            'email.unique'=>'email deja utilisé',
            'password.required'=>'mot de passe obligatoire',
            'password.confirmed'=>'la confirmation du mot de passe ne correspond pas',
            'password.password' => 'Le mot de passe doit contenir au moins 8 caractères, inclure des lettres majuscules et minuscules, des chiffres et des symboles.'
        ]);
        DB::beginTransaction();
        try{
            $user = User::create([
                'name'=> "{$request->name},{$request->last_name}",
                'email'=>$request->email,
                'password'=> Hash::make($request->password),
            ]);
            $client = Client::create([
                'user_id'=>$user,
                'name'=>$request->name,
                'last_name'=>$request->last_name,
                'email'=>$user->email,
                'contry'=>$request->contry,
                'city'=>$request->city,
                'street'=>$request->street ?? null,
                'postal_code'=>$request->postal_code,
                'phone'=>$request->phone ?? null,
                'description'=>$request->description ?? null,
                ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message'=>'client enregistré avec succés',
                'client'=>new ClientRessource($client),
                'token'=> $token,
                'token_type'=>'Bearer'
            ]);
            
        }catch(\Exception $e){  
            DB::rollBack();

            return response()->json([
                'error'=> $e->getMessage(),
                ],
            );
        }
    }
    public function login(Request $request){}
}