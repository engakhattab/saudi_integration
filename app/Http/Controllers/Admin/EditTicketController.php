<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;
use App\Models\product;
use App\Models\TicketRevModel;
use App\Models\TicketRevProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\VisitorTypes;
class EditTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }

    public function index(Request $request)
    {
        $starting_date = $request->has('starting_date') && strtotime($request->starting_date)
            ? $request->starting_date
            : date('Y-m-d');

        $ending_date = $request->has('ending_date') && strtotime($request->ending_date)
            ? $request->ending_date
            : date('Y-m-d');

        if ($request->ajax()) {
            $tickets = Ticket::latest()
                ->whereBetween('visit_date', [$starting_date, $ending_date]);

            if ($request->filled('payment_method')) {
                $tickets->where('payment_method', $request->payment_method);
            }

            if ($request->filled('employee_id')) {
                $tickets->where('add_by', $request->employee_id);
            }

            if ($request->filled('payment_status')) {
                $tickets->where('payment_status', $request->payment_status);
            }


            return Datatables::of($tickets)
                ->editColumn('add_by', function ($tickets) {
                    return (User::where('id', $tickets->add_by)->first()->name) ?? '---';
                })
                ->editColumn('client_id', function ($ticket) {
                    return $ticket->client ? $ticket->client->name : '---';
                })
                ->editColumn('payment_status', function ($ticket) {
                    return $ticket->payment_status
                        ? '<span class="badge badge-success">Paid</span>'
                        : '<span class="badge badge-danger">Not Paid</span>';
                })

                ->editColumn('status', function ($ticket) {
                    if ($ticket->status === 'out') {
                        return '<span class="badge bg-danger text-white">Out</span>';
                    } elseif ($ticket->status === 'in') {
                        return '<span class="badge bg-success text-white">In</span>';
                    } else {
                        return '<span class="badge bg-warning text-dark">Appaned</span>';
                    }
                })


                ->editColumn('visitors', function ($ticket) {
                    return $ticket->models->count() ?? '---';
                })
                ->editColumn('created_at', function ($ticket) {
                    return $ticket->created_at ? $ticket->created_at->format('h:i A') : '---';
                })
                ->addColumn('ticket_types', function ($ticket) {
                    return '<span class="icon showSpan" data-bs-toggle="tooltip" title="Show details" data-id="' . $ticket->id . '">
                                <i class="fa fa-eye" style="font-size: 30px; cursor: pointer;"></i>
                            </span>';
                })

                ->addColumn('discount_value', function ($ticket) {
                    $discountBadge = '<span class="badge bg-danger small-badge">' . trans('Discount') . '</span>';
                    $notDiscountBadge = '<span class="badge bg-success small-badge">' . trans('Not Discount') . '</span>';

                    return $ticket->discount_value ? $discountBadge : $notDiscountBadge;
                })

                ->editColumn('payment_status', function ($tickets) {
                    if ($tickets->payment_status == 0 or $tickets->paid_amount == 0) {
                        return '<span class="badge badge-danger">Not Paid</span>';
                    } else {
                        return '<span class="badge badge-success">Paid</span>';
                    }
                })

                ->addColumn('cancel', function ($ticket) {
                    $ticketRevs = TicketRevModel::where('ticket_id', '=', $ticket->id)->get();
                    $isCanceled = True;
                    foreach ($ticketRevs as $ticketRev) {
                        if ($ticketRev->cancel) {
                            $isCanceled = False;
                            break;
                        }
                    }
                    if ($isCanceled) {
                        return '<span class="badge badge-danger">' . trans('Cancel') . '</span>';
                    } else {
                        return '<span class="badge badge-success">' . trans('Active') . '</span>';
                    }
                })

                ->addColumn('actions', function ($ticket) {
                    $editIcon = '<a href="'. route('tickets.edit', $ticket->id) .'" data-bs-toggle="tooltip" title="Edit">
                                     <i class="fa fa-edit" style="font-size: 25px;"></i>
                                 </a>';

                    $deleteIcon = '<span type="button" class="delete" data-bs-toggle="tooltip" title="Delete" data-id="' . $ticket->id . '" aria-label="delete">
                                       <i class="fa fa-trash" style="font-size: 25px;"></i>
                                   </span>';

                    $canceled = false;
                    foreach ($ticket->models as $model) {
                        if ($model->cancel == 0) {
                            $canceled = true;
                            break; // Exit the loop if any model is canceled
                        }
                    }

                    $cancelIcon = $canceled
                        ? '<span data-bs-toggle="tooltip" title="Canceled">
                               <i class="fas fa-times-circle" style="font-size: 20px; color: gray;"></i>
                           </span>'
                        : '<span type="button" class="cancel" data-bs-toggle="tooltip" title="Cancel" data-id="' . $ticket->id . '">
                               <i class="fas fa-times-circle" style="font-size: 25px; color: orange;"></i>
                           </span>';

                    return $editIcon . ' ' . $cancelIcon . ' ' . $deleteIcon;
                })


                ->escapeColumns([])
                ->make(true);
        } else {
            $events = Event::all();
            $employees = User::all();
            return view('Admin.edit_Ticket.index', compact('starting_date', 'ending_date', 'events', 'employees', 'request'));
        }
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->visit_date = Carbon::parse($ticket->visit_date); // Ensure it's a Carbon instance
        $employees = User::all();
        $models = TicketRevModel::where('ticket_id', $id)->get();
        $types = VisitorTypes::all(); // Fetching types from the database

        return view('Admin.edit_Ticket.edit', compact('ticket', 'employees', 'types', 'models'));
    }

    public function update(Request $request, $id)
    {
        // Find the ticket by ID or fail with a 404 error
        $ticket = Ticket::findOrFail($id);
        $hoursCount = $ticket->hours_count;

        // Fetching top_up_hours correctly
        $totalTopUpHours = TicketRevModel::where('ticket_id', $ticket->id)->sum('top_up_hours');

        // Validate the incoming request data
        $validatedData = $request->validate([
            'visit_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'add_by' => 'nullable|exists:users,id',
            'payment_status' => 'nullable|boolean',
            'discount_value' => 'nullable|numeric',
            'total_price' => 'nullable|numeric',
            'ticket_price' => 'nullable|numeric',
            'rem_amount' => 'nullable|numeric',
            'status' => 'nullable|string',
            'cancel' => 'nullable|boolean',
            'payments' => 'nullable|array',
            'ticket_rev_models' => 'nullable|array',
        ]);

        // Initialize variables
        $visitDate = $validatedData['visit_date'];
        $newStatus = $validatedData['status'];
        $newCancel = $validatedData['cancel'] ?? false;

        // Get shift times based on ticket creation time
        $createdAt = $ticket->created_at;
        $shiftStart = $createdAt->format('H:00:00');
        $shiftEnd = $createdAt->addHours($hoursCount+$totalTopUpHours)->format('H:00:00');
        $startAt = Carbon::createFromFormat('H:i:s', $ticket->created_at->format('H:i:s'));


        try {
            DB::transaction(function () use ($ticket, $validatedData, $visitDate, $newStatus, $newCancel, $shiftStart, $shiftEnd ,$startAt) {
                // Delete existing Ticket Rev Models
                $ticket->models()->delete();

                // Update related Payment records
                foreach ($validatedData['payments'] ?? [] as $paymentId => $paymentData) {
                    Payment::updateOrCreate(
                        ['ticket_id' => $ticket->id, 'id' => $paymentId],
                        array_merge($paymentData, ['day' => $visitDate])
                    );
                }

                // Update related TicketRevModel records
                foreach ($validatedData['ticket_rev_models'] ?? [] as $modelId => $modelData) {
                    // Check if the model exists
                    $ticketRevModel = TicketRevModel::where('ticket_id', $ticket->id)->where('id', $modelId)->first();

                    if ($ticketRevModel) {
                        $updateData = [
                            'day' => $visitDate,
                            'status' => $newStatus,
                            'cancel' => $newCancel,
                            'shift_end' => $shiftEnd
                        ];

                        // Update the existing record
                        $ticketRevModel->update(array_merge($updateData, $modelData));

                    } else {
                        // Create a new record if it doesn't exist
                        TicketRevModel::create(array_merge($modelData, [
                            'ticket_id' => $ticket->id,
                            'day' => $visitDate,
                            'status' => $newStatus,
                            'cancel' => $newCancel,
                            'created_at' => $ticket->created_at,
                            'shift_start' => $shiftStart,
                            'shift_end' => $shiftEnd,
                            'start_at' => $startAt,
                            'price' => $modelData['price'] ?? 0,
                            // 'total_after_discount' => $modelData['price'] ?? 0,
                        ]));
                    }
                }

                // Financial calculations
                $totalRevModelPrice = TicketRevModel::where('ticket_id', $ticket->id)->sum('price');
                $totalRevModelTopUP = TicketRevModel::where('ticket_id', $ticket->id)->sum('top_up_price');
                $totalPayments = Payment::where('ticket_id', $ticket->id)->sum('amount');

                if ($totalPayments > 0) {
                    $ticketPrice = round($totalRevModelPrice / 1.15, 2);
                    $vat = round($totalPayments - ($totalPayments / 1.15), 2);
                    $totalTopUp = $totalRevModelTopUP;
                } else {
                    $ticketPrice = 0;
                    $vat = 0;
                    $totalTopUp = 0;
                }

                $maxTopUpHours = TicketRevModel::where('ticket_id', $ticket->id)->max('top_up_hours');

                // Update the ticket with new values
                $ticket->update([
                    'total_price' => $totalPayments,
                    'grand_total' => $totalPayments,
                    'paid_amount' => $totalPayments,
                    'vat' => $vat,
                    'total_top_up_price' => $totalTopUp,
                    'ticket_price' => $ticketPrice,
                    'status' => $newStatus,
                    'visit_date' => $visitDate,
                    'payment_method' => $validatedData['payment_method'],
                    'add_by' => $validatedData['add_by'],
                    'rem_amount' => $validatedData['rem_amount'],
                    'total_top_up_hours' => $maxTopUpHours,
                ]);
            });

            return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'Failed to update the ticket.');
        }
    }



    public function delete_ticket(request $request){
        $ticket = Ticket::where('id', $request->id)->first();
        $ticket->products()->delete();
        if($ticket) {
            foreach ($ticket->models as $model){
                $model->delete();
            }
            $ticket->delete();
            return response()->json(['status' => 200, 'ticket_number' => $ticket->ticket_num]);

        }
        else
            return response(['message' => "You Can't Delete This Reservation !", 'status' => 405], 200);
    }


}





