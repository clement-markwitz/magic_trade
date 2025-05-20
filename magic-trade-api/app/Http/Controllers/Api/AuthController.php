<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientRessource;
use App\Http\Resources\UserResource;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'phone'=>['string','max:20'],
            'description'=>['string','max:1000'],
        ],[
            'name'=>'le prénom est obligatoire',
            'last_name'=>'le nom est obligatoire',
            'pseudo.required'=>'le pseudo est obligatoire',
            'pseudo.unique'=>'pseudo deja utilisé',
            'contry'=>'le pays est obligatoire',
            'city'=>'la ville est obligatoire',
            'postal_code'=>'le code postal est obligatoire',
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
            $user->assignRole('client');
            $client = Client::create([
                'user_id'=>$user->id,
                'name'=>$request->name,
                'last_name'=>$request->last_name,
                'pseudo'=> $request->pseudo,
                'email'=>$user->email,
                'contry'=>$request->contry,
                'city'=>$request->city,
                'street'=>$request->street ?? null,
                'postal_code'=>$request->postal_code,
                'phone'=>$request->phone ?? null,
                'description'=>$request->description ?? null,
                ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
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
    public function login(Request $request){
        $credentials=$request->validate([
            'email'=> ['required','email'],
            'password'=> 'required',
        ],[
            'email.required'=>'email requis',
            'email.email'=>'format de l\'email incorrect'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
            'error' => 'Utilisateur non trouvé'
            ], 401);
        }
        if (Auth::attempt($credentials)){
            $user=Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message'=> 'connexion réussi',
                'user'=>new UserResource($user),
                'token'=> $token,
                'token_type'=>'Bearer'
                ]);
        }
        return response()->json([ 
            'error'=> 'utilisateur introuvable'
            ],401);
    }
    public function logout(Request $request)
    {
        // Révoquer le token actuel
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Déconnecté avec succès']);
    }
    
}