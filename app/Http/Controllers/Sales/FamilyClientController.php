<?php
namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;

class FamilyClientController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // Fetch clients with pagination, applying search if present
        $clients = Clients::latest()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%')
                             ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->paginate(10); // Change this line to use paginate

        // Pass the clients and search query to the view
        return view('sales.family-clients', compact('clients', 'search'));
    }

    public function rateClient(Request $request)
    {
        $client = Clients::find($request->id);
        $client->update([
            'note' => $request->note,
            'rate' => $request->rateForm,
        ]);
        return response(['message' => 'Rated Successfully', 'status' => 200], 200);
    }
}
