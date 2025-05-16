<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Auth;
use Illuminate\Http\Request;

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
    public function update(Request $request, string $id)
    {
        $client=Client::find($id);
        $request->validate([
            
        ])
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
