<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use App\Models\Product;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\VisitorTypes;
use App\Models\Reservations;
use App\Models\TicketRevModel;
use App\Models\User;
use App\Models\TicketRevProducts;
class EditGroupController extends Controller
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
            $reservations = Reservations::latest()
                ->whereBetween('day', [$starting_date, $ending_date]);

            if ($request->filled('payment_method')) {
                $reservations->where('payment_method', $request->payment_method);
            }

            if ($request->filled('employee_id')) {
                $reservations->where('add_by', $request->employee_id);
            }

            if ($request->filled('payment_status')) {
                $reservations->where('payment_status', $request->payment_status);
            }
            if ($request->has('event_id') && $request->event_id != '')
                $reservations->where('event_id', $request->event_id);

            $reservations = $reservations->get();

                 return DataTables::of($reservations)
                ->editColumn('add_by', function ($reservations) {
                    return User::find($reservations->add_by)->name ?? '---';
                })
                ->editColumn('client_id', function ($reservations) {
                    return $reservations->client_name ??  '---';
                })
                ->editColumn('event_id', function ($reservations) {
                    return ($reservations->event->title) ?? '---';
                })
                ->editColumn('payment_status', function ($reservations) {
                    return $reservations->payment_status
                        ? '<span class="badge badge-success">Paid</span>'
                        : '<span class="badge badge-danger">Not Paid</span>';
                })
                ->editColumn('visitors', function ($reservations) {
                    return $reservations->models->count() ?? '---';
                })

                ->editColumn('status', function ($reservations) {
                    if ($reservations->status === 'out') {
                        return '<span class="badge bg-danger text-white">Out</span>';
                    } elseif ($reservations->status === 'in') {
                        return '<span class="badge bg-success text-white">In</span>';
                    } else {
                        return '<span class="badge bg-warning text-dark">Appaned</span>';
                    }
                })
                ->editColumn('created_at', function ($reservations) {
                    return $reservations->created_at ? $reservations->created_at->format('h:i A') : '---';
                })
                ->addColumn('ticket_types', function ($reservations) {
                    return '<span class="icon showSpan" data-bs-toggle="tooltip" title="Show details" data-id="' . $reservations->id . '">
                                <i class="fa fa-eye" style="font-size: 20px; cursor: pointer;"></i>
                            </span>';
                })

                ->editColumn('product_price', function ($reservation) {
                    $total = TicketRevProducts::where('rev_id', $reservation->id)->sum('total_price');
                    return number_format($total / 1.15, 2, '.', '');
                })

                ->editColumn('payment_status', function ($reservations) {
                    if ($reservations->payment_status == 0 or $reservations->paid_amount == 0) {
                        return '<span class="badge badge-danger">Not Paid</span>';
                    } else {
                        return '<span class="badge badge-success">Paid</span>';
                    }
                })
                   ->addColumn('cancel', function ($reservations) {
                    $ticketRevs = TicketRevModel::where('rev_id', '=', $reservations->id)->get();
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
                ->addColumn('actions', function ($reservations) {
                    $editIcon = '<a href="'. route('groups.edit', $reservations->id) .'" data-bs-toggle="tooltip" title="Edit">
                                     <i class="fa fa-edit" style="font-size: 20px;"></i>
                                 </a>';

                    $deleteIcon = '<span type="button" class="delete" data-bs-toggle="tooltip" title="Delete" data-id="' . $reservations->id . '" aria-label="delete">
                                       <i class="fa fa-trash" style="font-size: 20px;"></i>
                                   </span>';

                    $canceled = false;
                    foreach ($reservations->models as $model) {
                        if ($model->cancel == 0) {
                            $canceled = true;
                            break; // Exit the loop if any model is canceled
                        }
                    }

                    $cancelIcon = $canceled
                        ? '<span data-bs-toggle="tooltip" title="Canceled">
                               <i class="fas fa-times-circle" style="font-size: 20px; color: gray;"></i>
                           </span>'
                        : '<span type="button" class="cancel" data-bs-toggle="tooltip" title="Cancel" data-id="' . $reservations->id . '">
                               <i class="fas fa-times-circle" style="font-size: 20px; color: orange;"></i>
                           </span>';

                    return $editIcon . ' ' . $cancelIcon . ' ' . $deleteIcon;
                })

                ->escapeColumns([])
                ->make(true);
        } else {
            $events = Event::all();
            $employees = User::all();
            return view('Admin.editGroup.index', compact('starting_date', 'ending_date', 'events', 'employees', 'request'));
        }
    }


    public function edit($id)
    {
        try {
            $reservation = Reservations::findOrFail($id);
            $reservation->day = Carbon::parse($reservation->day);
            $hoursCount = $reservation->hours_count;
            $shiftId = $reservation->shift_id;
            $employees = User::all();
            $models = TicketRevModel::where('rev_id', $id)->get();
            $types = VisitorTypes::all();
            $products = Product::all();
            $events = Event::all();
            $categories = Category::all();

            return view('Admin.editGroup.edit', compact('reservation', 'employees', 'types', 'models', 'categories', 'events', 'products', 'hoursCount','shiftId'));
        } catch (\Exception $e) {
            // Handle the exception (log it, return an error response, etc.)
            return redirect()->route('groups.index')->with('error', 'Ticket not found or error occurred.');
        }
    }

    public function update(Request $request, $id)
    {
        // Find the ticket by ID or fail with a 404 error
        $reservation = Reservations::findOrFail($id);
        $hoursCount = $reservation->hours_count;

        // Fetching top_up_hours correctly
        $totalTopUpHours = TicketRevModel::where('rev_id', $reservation->id)->sum('top_up_hours');

        // Validate the incoming request data
        $validatedData = $request->validate([
            'day' => 'required|date',
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
            'ticket_rev_products' => 'nullable|array',

        ]);

        // Initialize variables
        $visitDate = $validatedData['day'];
        $newStatus = $validatedData['status'];
        $newCancel = $validatedData['cancel'] ?? false;

        // Get shift times based on ticket creation time
        $createdAt = $reservation->created_at;
        $shiftStart = $createdAt->format('H:00:00');
        $shiftEnd = $createdAt->addHours($hoursCount + $totalTopUpHours)->format('H:00:00');
        $startAt = Carbon::createFromFormat('H:i:s', $reservation->created_at->format('H:i:s'));

        try {
            DB::transaction(function () use ($reservation, $validatedData, $visitDate, $newStatus, $newCancel, $shiftStart, $shiftEnd, $startAt) {
                // Delete existing Ticket Rev Models
                $reservation->models()->delete();
                $reservation->products()->delete();

                // Update related Payment records
                foreach ($validatedData['payments'] ?? [] as $paymentId => $paymentData) {
                    Payment::updateOrCreate(
                        ['rev_id' => $reservation->id, 'id' => $paymentId],
                        array_merge($paymentData, ['day' => $visitDate])
                    );
                }

                // Update related TicketRevModel records
                foreach ($validatedData['ticket_rev_models'] ?? [] as $modelId => $modelData) {
                    $ticketRevModel = TicketRevModel::where('rev_id', $reservation->id)->where('id', $modelId)->first();

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
                            'rev_id' => $reservation->id,
                            'day' => $visitDate,
                            'status' => $newStatus,
                            'cancel' => $newCancel,
                            'created_at' => $reservation->created_at,
                            'shift_start' => $shiftStart,
                            'shift_end' => $shiftEnd,
                            'start_at' => $startAt,
                            'price' => $modelData['price'] ?? 0,
                        ]));
                    }
                }

                // Financial calculations
                $financials = $this->calculateFinancials($reservation->id);

                // Update the ticket with new values
                $reservation->update(array_merge($financials, [
                    'day' => $visitDate,
                    'payment_method' => $validatedData['payment_method'],
                    'add_by' => $validatedData['add_by'],
                    'rem_amount' => $validatedData['rem_amount'],
                    'status' => $newStatus,
                ]));
            });

            // Save ticket products
            if (isset($validatedData['ticket_rev_products'])) {
                foreach ($validatedData['ticket_rev_products'] as $productData) {
                    if (!empty($productData['product_id'])) {
                        $qty = $productData['qty'] ?? 0;
                        $price = $productData['price'] ?? 0;

                        // Create product entry
                        $reservation->products()->create([
                            'product_id' => $productData['product_id'],
                            'qty' => $qty,
                            'price' => $price,
                            'category_id' => $productData['category_id'] ?? null,
                            'total_price' => $qty * $price,
                        ]);
                    }
                }
            }

            return redirect()->route('groups.index')->with('success', 'Ticket updated successfully.');
        } catch (\Exception $e) {

            return redirect()->route('groups.index')->with('error', 'Failed to update the ticket.');
        }
    }

    protected function calculateFinancials($reservationId)
    {
        $totalRevModelPrice = TicketRevModel::where('rev_id', $reservationId)->sum('price');
        $totalRevModelTopUP = TicketRevModel::where('rev_id', $reservationId)->sum('top_up_price');
        $totalPayments = Payment::where('rev_id', $reservationId)->sum('amount');

        if ($totalPayments > 0) {
            $ticketPrice = round($totalRevModelPrice / 1.15, 2);
            $vat = round($totalPayments - ($totalPayments / 1.15), 2);
            $totalTopUp = $totalRevModelTopUP;
        } else {
            $ticketPrice = $vat = $totalTopUp = 0;
        }

        return [
            'total_price' => $totalPayments,
            'grand_total' => $totalPayments,
            'paid_amount' => $totalPayments,
            'vat' => $vat,
            'total_top_up_price' => $totalTopUp,
            'ticket_price' => $ticketPrice,
            'total_top_up_hours' => TicketRevModel::where('rev_id', $reservationId)->max('top_up_hours'),
        ];
    }



        public function delete_reservation(Request $request) {
            $reservation = Reservations::where('id', $request->id)->first();
            $reservation->products()->delete();
                if($reservation) {
                    foreach ($reservation->models as $model){
                        $model->delete();
                    }
                    $reservation->delete();
                    return response()->json(['status' => 200, 'ticket_number' => $reservation->ticket_num]);

                }
                else
                    return response(['message' => "You Can't Delete This Reservation !", 'status' => 405], 200);
            }


    }








