<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketRevModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QueryController extends Controller
{
    /**
     * Display the query page.
     */
    public function index()
    {
        // Just return the view with no initial data
        return view('sales.query.index');
    }

    /**
     * Search for sales data on a specific date and time.
     */
    public function search(Request $request)
    {
        // 1. Validate that the user has selected a date and a time
        $request->validate([
            'query_date' => 'required|date',
            'query_time' => 'required',
        ]);

        $selectedDate = $request->input('query_date');
        $selectedTime = $request->input('query_time');

        // 2. Find all individual visitors (TicketRevModel) who will be in the park at the selected time
        $visitorsAtTime = TicketRevModel::where('day', $selectedDate)
            ->where('shift_start', '<=', $selectedTime)
            ->where('shift_end', '>', $selectedTime)
            ->get();

        // 3. Count the total number of visitors found
        $totalVisitors = $visitorsAtTime->count();

        // 4. Get the unique ticket IDs from the visitors we found
        $ticketIds = $visitorsAtTime->pluck('ticket_id')->unique();

        // 5. Fetch the full ticket information for those unique IDs
        $tickets = Ticket::whereIn('id', $ticketIds)->with('client')->get();

        // 6. Return the view with all the new data
        return view('sales.query.index', [
            'totalVisitors' => $totalVisitors,
            'tickets'       => $tickets,
            'queriedDate'   => $selectedDate,
            'queriedTime'   => $selectedTime,
        ]);
    }
}
