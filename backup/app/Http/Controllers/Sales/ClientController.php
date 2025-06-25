<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Governorate;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function __construct()
    {

        $this->middleware('permission:Add Client');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $governorates = Governorate::with('cities')->latest()->get();
        $references = Reference::latest()->get();

        return view('sales.add-client', compact('governorates', 'references'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:clients,phone',
            'email' => 'nullable|unique:clients,email',
            'gender' => 'nullable',
            'gov_id' => 'nullable',
            'city_id' => 'nullable',
            'ref_id' => 'nullable',
            'family_size' => 'nullable|max:11',
            'building' => 'nullable|max:11',
            'street' => 'nullable',
            'address' => 'nullable',
            'district' => 'nullable',
            'vat_num' => 'nullable',
        ]);
        $client = Clients::create($data);
        // check if code is run on domain not local host
        if ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1:8000')
            $client->update(['uploaded' => true]);


        if ($client)
            return response()->json(['data' => $client, 'status' => 200], 200);
        else
            return response()->json(405);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $client = Clients::where('phone', $request->phone)->first();
        if ($client)
            return response()->json(['client' => $client, 'status' => 200], 200);
        else
            return response()->json(['client' => null, 'status' => 405], 200);
    }

    public function show($id)
    {
        return $id;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
