<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientRessource;
use App\Models\Client;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients=Client::all();
        return response()->json($clients);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client=Client::find($id);
        return response()->json($client);
    }
    public function me(){
        $client=Client::find(Auth::user()->id);
        return response()->json($client);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
         $validated=$request->validate([
            'current_password'=>['required','string'],
            'name'=>['string','max:50'],
            'last_name'=>['string','max:100'],
            'pseudo'=>['string','max:20','unique:clients,pseudo'],
            'contry'=>['string','max:50'],
            'city'=>['string','max:100'],
            'street'=>['string','max:100'],
            'postal_code'=>['string','digits:5'],
            'phone'=>['string','max:20'],
            'description'=>['string','max:1000'],
            'email'=>['email']
            ]
        ,[
            'pseudo.unique'=>'pseudo deja utilisé',
            'description'=> 'description trop longue (1000 caractères) '
        ]);
        $validated_user=$request->validate([
            'email'=>['email'],
            'password'=>[Password::min(8)
        ->letters()
        ->mixedCase()
        ->numbers()
        ->symbols()
        ,'confirmed']
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
        return response()->json([
            'message' => 'Le mot de passe actuel est incorrect',
            'errors' => ['current_password' => ['Le mot de passe fourni est incorrect']]
        ], 422);
        }
        unset($validated['current_password']);

        $user=User::find(Auth::user()->id);
        $user->update($validated_user);

        $client = Client::find($user->client->id);
        $client->update($validated);

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'client' => new ClientRessource($client),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
