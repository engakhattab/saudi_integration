<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;

class FamilyClientController extends Controller
{
    public function index(){
        $clients = Clients::latest()->paginate(10);
        return view('sales.family-clients',compact('clients'));
    }

    public function rateClient(request $request){
        $client = Clients::find($request->id);
        $client->update([
            'note' => $request->note,
            'rate' => $request->rateForm,
        ]);
        return response(['message' => 'Rated Successfully', 'status' => 200], 200);
    }
}
