<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Reference;
use App\Models\ReturnAmount;
use App\Models\Ticket;
use App\Models\DiscountReasons;
use App\Models\Reservations;
use App\Models\TicketRevModel;
use App\Models\User;
use App\Models\TicketRevProducts;
use App\Models\Event;
use App\Models\VisitorTypes;
use App\Models\Payment;
use Carbon\Carbon;
use App\Services\ZatcaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
{
    public function __construct(ZatcaService $zatcaService)
    {
        $this->zatcaService = $zatcaService;
        $this->middleware('adminPermission:Branch Admin');
    }

    public function index(request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i');
        $ending_time = date('Y-m-d H:i');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');


        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');

        if ($request->ajax()) {
            $tickets = Ticket::latest();


            if ($request->has('payment_method') && $request->payment_method != '')
                $tickets->where('payment_method', $request->payment_method);

            if ($request->has('ending_time') && $request->ending_time != '') {

                $tickets->where('created_at', '>=', $starting_time)->where('created_at', '<=', $ending_time)
                    ->where(function ($query) use ($starting_time, $ending_time) {
                        $query->where('created_at', '>=', $starting_time)
                            ->where('created_at', '<=', $ending_time);
                    });
            }
            if ($request->has('employee_id') && $request->employee_id != '')
                $tickets->where('add_by', $request->employee_id);

            if ($request->has('payment_status') && $request->payment_status != '')
                $tickets->where('payment_status', $request->payment_status);


            $tickets = $tickets->get();

            return Datatables::of($tickets)
                ->editColumn('add_by', function ($tickets) {
                    return (User::where('id', $tickets->add_by)->first()->name) ?? '---';
                })
                ->editColumn('client_id', function ($tickets) {
                    return ($tickets->client->name) ?? '---';
                })
                ->editColumn('payment_status', function ($tickets) {
                    if ($tickets->payment_status == 0) {
                        return '<span class="badge badge-danger">Not Paid</span>';
                    } else {
                        return '<span class="badge badge-success">Paid</span>';
                    }
                })
                ->editColumn('visitors', function ($tickets) {
                    return ($tickets->models->count()) ?? '---';
                })
                ->editColumn('created_at', function ($tickets) {
                    return ($tickets->created_at->format('Y-m-d')) ?? '---';
                })
                ->addColumn('ticket_types', function ($tickets) {
                    return '<span style="cursor:pointer" class="icon btn btn-info showSpan" data-bs-toggle="tooltip" title=" details " data-id="' . $tickets->id . '">Show <i class="fa fa-eye"></i></span>';
                })
                ->addColumn('discount_value', function ($tickets) {
                    if ($tickets->discount_value == False) {
                        return '<span class="badge badge-success">' . trans('Not Discount') . '</span>';
                    } else {
                        return '<span class="badge badge-danger">' . trans('Discount') . '</span>';
                    }

                })
                ->addColumn('cancel', function ($tickets) {
                    $Cancel = $tickets->cancel;
                    $tickets = TicketRevModel::where('ticket_id', '=', $tickets->id)->get();
                    foreach ($tickets as $tickets) {

                    }
                    if ($tickets->cancel == False) {
                        return '<span class="badge badge-danger">' . trans('Cancel') . '</span>';
                    } else {
                        return '<span class="badge badge-success">' . trans('Active') . '</span>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            $events = Event::all();
            $employees = User::all();
            return view('Admin/sales/index', compact('starting_date', 'ending_date', 'events', 'employees', 'request', 'starting_time', 'ending_time'));
        }
    }//end fun


    /*
     * start of cancel Ticket
     */


    public function cancel(request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');


//        if ($request->ajax()) {
//            $tickets = Ticket::latest()->where('created_at','=',date('Y-m-d'));

        if ($request->ajax()) {
            $tickets = Ticket::latest()->where('visit_date', '>=', $starting_date)
                ->where('visit_date', '<=', $ending_date);

            if ($request->has('payment_method') && $request->payment_method != '')
                $tickets->where('payment_method', $request->payment_method);


            if ($request->has('employee_id') && $request->employee_id != '')
                $tickets->where('add_by', $request->employee_id);

            if ($request->has('payment_status') && $request->payment_status != '')
                $tickets->where('payment_status', $request->payment_status);


            $tickets = $tickets->get();

            return Datatables::of($tickets)
                ->editColumn('add_by', function ($tickets) {
                    return (User::where('id', $tickets->add_by)->first()->name) ?? '---';
                })
                ->editColumn('client_id', function ($tickets) {
                    return ($tickets->client->name) ?? '---';
                })
                ->editColumn('payment_status', function ($tickets) {
                    if ($tickets->payment_status == 0) {
                        return '<span class="badge badge-danger">Not Paid</span>';
                    } else {
                        return '<span class="badge badge-success">Paid</span>';
                    }
                })
                ->editColumn('visitors', function ($tickets) {
                    return ($tickets->models->count()) ?? '---';
                })
                ->addColumn('ticket_types', function ($tickets) {
                    return '<span style="cursor:pointer" class="icon btn btn-info showSpan" data-bs-toggle="tooltip" title=" details " data-id="' . $tickets->id . '">Show <i class="fa fa-eye"></i></span>';
                })
                ->addColumn('cancel', function ($tickets) {

                    if ($tickets->total_price == 0)
                        return '<span style="cursor:pointer" class="icon btn btn-danger" data-bs-toggle="tooltip">Canceled</span>';
                    else
                        return '<span style="cursor:pointer" class="icon btn btn-info cancel" data-bs-toggle="tooltip" title=" details " data-id="' . $tickets->id . '">Cancel Ticket</span>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            $events = Event::all();
            $employees = User::all();
            return view('Admin/sales/cancel', compact('starting_date', 'ending_date', 'events', 'employees', 'request'));
        }
    }//end fun

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * cancelUpdateMethod
     */
    public function cancelUpdateMethod(Request $request)
    {
        $ticket = Ticket::where('id', '=', $request->id)->first();
        if ($ticket->odoo_invoice_id) {
            $this->syncCancelTicketWithOdoo($ticket);
        }

        $ticket->update(['total_price' => 0, 'total_top_up_price' => 0, 'total_top_down_price' => 0, 'discount_value' => 0, 'ticket_price' => 0, 'grand_total' => 0,
            'paid_amount' => 0, 'rem_amount' => 0, 'vat' => 0, 'ent_tax' => 0, 'status' => 'out', 'payment_status' => '0']);

        $ids = TicketRevModel::where('ticket_id', '=', $request->id)->pluck('id');
        foreach ($ids as $id) {
            TicketRevModel::where('id', $id)->update(['price' => 0, 'cancel' => 0, 'top_up_price' => 0, 'status' => 'out', 'total_after_discount' => 0]);
        }

        $productIds = TicketRevProducts::where('ticket_id', '=', $request->id)->pluck('id');
        foreach ($productIds as $productId) {
            TicketRevProducts::where('id', $productId)->update(['price' => 0, 'total_price' => 0, 'cancel' => 0]);
        }
        $payments = Payment::where('ticket_id', '=', $request->id)->pluck('id');
        foreach ($payments as $payment) {
            Payment::where('id', $payment)->update(['amount' => 0]);

        }

        $return_ids = ReturnAmount::where('ticket_id', '=', $request->id)->pluck('id');
        foreach ($return_ids as $return_id) {
            ReturnAmount::where('id', $return_id)->update(['amount' => 0]);

        }

        return response()->json(['status' => 200, 'ticket_number' => $ticket->ticket_num]);

    }

    /**
     * Sync ticket with Odoo
     */
    protected function syncCancelTicketWithOdoo($ticket)
    {
        try {
            // Wrood Ticket Sales settings
            $journalId = 13; // 1 for yasmeen 13 for wrood
            $teamId = 1; // Wrood Ticket Sales 3 Wrood Pos Sales  5 Yasmeen Ticket Sales - 6 Yasmeen Pos Sales
            $analyticDistribution = 4; // 1 for yasmeen pos --- 2 for yasmeen ticket ---3 for wrood pos 4 for wrood ticket
            $partnerId = 7; // 7 for partner
            $reversed_entry_id = 1;

            // Get invoice name
            $invoiceName = $this->zatcaService->getInvoice($ticket->odoo_invoice_id);
            $invoiceName = $invoiceName['name'];


            // Prepare invoice data for regular ticket invoice
            $invoiceData = [
                'partner_id' => $partnerId,
                'move_type' => 'out_refund', // out_invoice or out_refund
                'journal_id' => $journalId,
                'team_id' => $teamId,
                'reversed_entry_id' => $reversed_entry_id,
                'ref' => auth()->user()->name,
                'invoice_line_ids' => [
                    [
                        0, 0, [
                        'product_id' => 3, // 3 for ticket items
                        'name' => 'Refund Ticket Sale #' . $invoiceName,
                        'quantity' => 1,
                        'price_unit' => $ticket->paid_amount,
                        'analytic_distribution' => [$analyticDistribution => 100.0]
                    ]
                    ]
                ]
            ];

            // Create regular invoice in Odoo
            $invoiceId = $this->zatcaService->createInvoice($invoiceData);

            // Confirm the invoice
            $qrcode = $this->zatcaService->confirmInvoice($invoiceId);
            // Update ticket with Odoo invoice ID
            $ticket->update([
                'odoo_invoice_id' => $invoiceId,
                'odoo_sync_status' => 'refunded',
                'odoo_qrcode' => $qrcode ?? null
            ]);

        } catch (\Exception $e) {
            $ticket->update([
                'odoo_sync_status' => 'failed',
                'odoo_sync_error' => substr($e->getMessage(), 0, 255) // Store first 255 chars of error
            ]);
        }
    }


    public function reservationSale(request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');


        if ($request->ajax()) {
            $reservations = reservations::latest()->where('day', '>=', $starting_date)
                ->where('day', '<=', $ending_date)
                ->orWhereDay('created_at', Carbon::now()->format('d'));

            if ($request->has('payment_method') && $request->payment_method != '')
                $reservations->where('payment_method', $request->payment_method);


            if ($request->has('employee_id') && $request->employee_id != '')
                $reservations->where('add_by', $request->employee_id);

            if ($request->has('payment_status') && $request->payment_status != '')
                $reservations->where('payment_status', $request->payment_status);

            if ($request->has('event_id') && $request->event_id != '')
                $reservations->where('event_id', $request->event_id);

            $reservations = $reservations->get();

            return Datatables::of($reservations)
                ->editColumn('add_by', function ($reservations) {
                    return (User::where('id', $reservations->add_by)->first()->name) ?? '---';
                })
                ->editColumn('client_id', function ($reservations) {
                    return ($reservations->client_name) ?? '---';
                })
                ->editColumn('event_id', function ($reservations) {
                    return ($reservations->event->title) ?? '---';
                })
                ->editColumn('visitors', function ($reservations) {
                    return ($reservations->models->count()) ?? '---';
                })
                ->addColumn('ticket_types', function ($reservations) {
                    return '<span style="cursor:pointer" class="icon btn btn-info showSpan" data-bs-toggle="tooltip" title="details" data-id="' . $reservations->id . '">Show <i class="fa fa-eye"></i></span>';
                })
                ->editColumn('product_price', function ($reservations) {

                    $total = 0;
                    $products = TicketRevProducts::where('rev_id', $reservations->id)->get();
                    foreach ($products as $product) {
                        $total += $product->price;
                    }
                    return number_format($total / 1.15, 2, '.', '');

                })
                ->editColumn('cancel', function ($reservations) {
                    if ($reservations->total_price == False) {
                        return '<span class="badge badge-danger">' . trans('Cancel') . '</span>';
                    } else {
                        return '<span class="badge badge-success">' . trans('Active') . '</span>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            $events = Event::all();
            $employees = User::all();
            return view('Admin/sales/reservations', compact('starting_date', 'request', 'ending_date', 'events', 'employees'));
        }
    }//ene fun

    /*
       * start of cancel Group
       */

    public function CancelGroup(request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->ajax()) {
            $reservations = Reservations::latest()->where('day', '>=', $starting_date)
                ->where('day', '<=', $ending_date)
                ->orWhereDay('created_at', Carbon::now()->format('d'));

            if ($request->has('payment_method') && $request->payment_method != '')
                $reservations->where('payment_method', $request->payment_method);


            if ($request->has('employee_id') && $request->employee_id != '')
                $reservations->where('add_by', $request->employee_id);

            if ($request->has('payment_status') && $request->payment_status != '')
                $reservations->where('payment_status', $request->payment_status);

            if ($request->has('event_id') && $request->event_id != '')
                $reservations->where('event_id', $request->event_id);


            $reservations = $reservations->get();

            return Datatables::of($reservations)
                ->editColumn('add_by', function ($reservations) {
                    return (User::where('id', $reservations->add_by)->first()->name) ?? '---';
                })
                ->editColumn('client_id', function ($reservations) {
                    return ($reservations->client_name) ?? '---';
                })
                ->editColumn('event_id', function ($reservations) {
                    return ($reservations->event->title) ?? '---';
                })
                ->editColumn('visitors', function ($reservations) {
                    return ($reservations->models->count()) ?? '---';
                })
                ->editColumn('payment_status', function ($reservations) {
                    if ($reservations->payment_status == 0) {
                        return '<span class="badge badge-danger">Not Paid</span>';
                    } else {
                        return '<span class="badge badge-success">Paid</span>';
                    }
                })
                ->addColumn('ticket_types', function ($reservations) {
                    return '<span style="cursor:pointer" class="icon btn btn-info showSpan" data-bs-toggle="tooltip" title="details" data-id="' . $reservations->id . '">Show <i class="fa fa-eye"></i></span>';
                })
                ->addColumn('cancel', function ($reservations) {

                    if ($reservations->total_price == 0)
                        return '<span style="cursor:pointer" class="icon btn btn-danger" data-bs-toggle="tooltip">Canceled</span>';
                    else
                        return '<span style="cursor:pointer" class="icon btn btn-info cancel" data-bs-toggle="tooltip" title=" details " data-id="' . $reservations->id . '">Cancel Ticket</span>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            $events = Event::all();
            $employees = User::all();
            return view('Admin/sales/CancelGroup', compact('starting_date', 'ending_date', 'events', 'employees', 'request'));
        }
    }//end fun

    public function CancelGroupUpdateMethod(Request $request)
    {
        $reservations = Reservations::where('id', '=', $request->id)->first();
        if ($reservations->odoo_invoice_id) {
            $this->syncCancelTicketWithOdoo($reservations);
        }

        $reservations = Reservations::where('id', '=', $request->id)->first();
        $reservations->update(['total_price' => 0, 'total_top_up_price' => 0, 'total_top_down_price' => 0, 'discount_value' => 0, 'ticket_price' => 0, 'grand_total' => 0,
            'paid_amount' => 0, 'rem_amount' => 0, 'vat' => 0, 'ent_tax' => 0, 'status' => 'out', 'payment_status' => '0']);

        $ids = TicketRevModel::where('rev_id', '=', $request->id)->pluck('id');
        foreach ($ids as $id) {
            TicketRevModel::where('id', $id)->update(['price' => 0, 'cancel' => 0, 'top_up_price' => 0, 'status' => 'out', 'total_after_discount' => 0]);
        }

        $productIds = TicketRevProducts::where('rev_id', '=', $request->id)->pluck('id');
        foreach ($productIds as $productId) {
            TicketRevProducts::where('id', $productId)->update(['price' => 0, 'total_price' => 0, 'cancel' => 0, 'qty' => 0]);
        }
        $payments = Payment::where('rev_id', '=', $request->id)->pluck('id');
        foreach ($payments as $payment) {
            Payment::where('id', $payment)->update(['amount' => 0]);

        }

        $return_ids = ReturnAmount::where('rev_id', '=', $request->id)->pluck('id');
        foreach ($return_ids as $return_id) {
            ReturnAmount::where('id', $return_id)->update(['amount' => 0]);

        }

        return response()->json(['status' => 200, 'ticket_number' => $reservations->ticket_num]);

    }

    /*
     * end of cancel Group
     */


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productSales(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');


        if ($request->ajax()) {
            $tickets = Ticket::latest()->where('visit_date', '>=', $starting_date)
                ->where('visit_date', '<=', $ending_date);

            if ($request->has('payment_method') && $request->payment_method != '')
                $tickets->where('payment_method', $request->payment_method);


            if ($request->has('employee_id') && $request->employee_id != '')
                $tickets->where('add_by', $request->employee_id);

            if ($request->has('payment_status') && $request->payment_status != '')
                $tickets->where('payment_status', $request->payment_status);

            if ($request->event_id == '0' || $request->event_id == '')
                $tickets = $tickets->with('products.product', 'client')->get()->toArray();
            else {
                $tickets = [];
            }

            $reservations = Reservations::latest()->where('day', '>=', $starting_date)
                ->where('day', '<=', $ending_date);


            if ($request->has('payment_method') && $request->payment_method != '')
                $reservations->where('payment_method', $request->payment_method);


            if ($request->has('employee_id') && $request->employee_id != '')
                $reservations->where('add_by', $request->employee_id);

            if ($request->has('payment_status') && $request->payment_status != '')
                $reservations->where('payment_status', $request->payment_status);

            if ($request->has('event_id') && $request->event_id != '') {
                $reservations->where('event_id', $request->event_id);
            }

            if ($request->event_id != '0' && $request->event_id != '') {
                $reservations = $reservations->where('event_id', $request->event_id)->with('event', 'products.product')->get()->toArray();
                $tickets = [];
            } elseif ($request->event_id == '') {
                $reservations = $reservations->with('event', 'products.product')->get()->toArray();
            } else
                $reservations = [];

            $endArray = array_merge($tickets, $reservations);
//            return $endArray;
            $productArray = [];
            $key = 0;
            foreach ($endArray as $item) {
                foreach ($item['products'] as $product) {
                    $key++;
                    $oneProduct = [];
                    $oneProduct['id'] = $key;
                    $oneProduct['add_by'] = (User::where('id', $item['add_by'])->first()->name) ?? '---';
                    $oneProduct['ticket_num'] = ($item['ticket_num']) ?? '---';
                    $oneProduct['product_name'] = $product['product']['title'] ?? '---';
                    $oneProduct['total_price'] = $product['total_price'] ?? '---';
                    $oneProduct['payment_method'] = $item['payment_method'] ?? '---';
                    $oneProduct['status'] = $item['payment_status'] == true ? 'Sale' : 'Cancelled';
                    $oneProduct['created_at'] = (date('Y-m-d', strtotime($item['created_at']))) ?? '---';
                    if (isset($item['event_id'])) {
                        $oneProduct['day'] = $item['day'];
                        $oneProduct['client'] = ($item['client_name']) ?? '---';
                        $oneProduct['phone'] = ($item['phone']) ?? '---';
                        $oneProduct['event'] = ($item['event']['title']) ?? '---';
                    } else {
                        $oneProduct['day'] = $item['visit_date'];
                        $oneProduct['client'] = ($item['client']['name']) ?? '---';
                        $oneProduct['phone'] = ($item['client']['phone']) ?? '---';
                        $oneProduct['event'] = 'Family';
                    }

                    $productArray[] = $oneProduct;
                }
            }


            return Datatables::of($productArray)
                ->escapeColumns([])
                ->make(true);

        }
        $events = Event::all();
        $employees = User::all();
        return view('Admin/sales/productSales', compact('starting_date', 'ending_date', 'events', 'employees', 'request'));


    }//end fun


    public function totalCashierSales(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i');
        $ending_time = date('Y-m-d H:i');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');

        $starting_time = date("Y-m-d H:i", strtotime($starting_time));
        $ending_time = date("Y-m-d H:i", strtotime($ending_time));


        if ($request->ajax()) {
            $request->all();
            $users = User::all();

            $users = Payment::select('id', 'cashier_id')->with('cashier')->groupBy('cashier_id')->get();

            $paymentMethods = ['cash', 'visa', 'mastercard', 'Meeza', 'voucher'];

            $cashierArray = [];
            foreach ($users as $user) {
                foreach ($paymentMethods as $paymentMethod) {
                    $oneCashier = [];
                    $oneCashier['name'] = @$user->cashier->name ?? "User deleted";
                    $oneCashier['payment_method'] = $paymentMethod;
                    $totalRev = 0;
                    $totalTicket = 0;
                    $reservation = Payment::latest()->whereBetween('created_at', [$starting_time, $ending_time]);

                    if ($request->has('payment_method') && $request->payment_method != '')
                        $reservation->where('payment_method', $request->payment_method);

                    if ($request->has('employee_id') && $request->employee_id != '')
                        $reservation->where('cashier_id', $request->employee_id);

                    $totalRev = $reservation
                        ->where('cashier_id', $user->cashier_id)
                        ->where('payment_method', $paymentMethod)
                        ->sum('amount');

//                    $ticket = ReturnAmount::latest()->whereDate('created_at', '>=', $starting_date);
                    $ticket = ReturnAmount::latest()->whereBetween('created_at', [$starting_time, $ending_time]);

                    if ($request->has('payment_method') && $request->payment_method != '')
                        $ticket->where('payment_method', $request->payment_method);


                    if ($request->has('employee_id') && $request->employee_id != '')
                        $ticket->where('cashier_id', $request->employee_id);

                    $totalTicket = $ticket
                        ->where('cashier_id', $user->cashier_id)
                        ->where('payment_method', $paymentMethod)
                        ->sum('amount');

                    $oneCashier['total'] = $totalRev - $totalTicket;
                    $cashierArray[] = $oneCashier;
                }
            }
            // $ticket = Payment::all();

            foreach ($cashierArray as $key => $item) {
                if ($item['total'] == 0)
                    unset($cashierArray[$key]);

            }


            return Datatables::of($cashierArray)
                ->escapeColumns([])
                ->make(true);

        }
        $events = Event::all();
        $employees = User::all();
        return view('Admin/sales/totalCashierSales', compact('starting_date', 'ending_date', 'events', 'employees', 'request', 'starting_time', 'ending_time'));

    }//end fun


    public function totalTodaySales(Request $request)
    {

        $starting_date = $request->get('starting_date', date('Y-m-d'));
        $ending_date = $request->get('ending_date', date('Y-m-d'));

// Adjust ending date to include the entire day

        if ($request->ajax()) {
            $ending_date = date('Y-m-d', strtotime($ending_date . ' +1 day'));

            $users = User::all();
            $paymentMethods = ['cash', 'visa', 'mastercard', 'Meeza', 'voucher'];
            $cashierArray = [];

            foreach ($users as $user) {
                foreach ($paymentMethods as $paymentMethod) {

                    $totalPrice = Ticket::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('ticket_price')
                        +
                        Reservations::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('ticket_price');

                    $TotalTopUpPrice = Ticket::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('total_top_up_price')
                        +
                        Reservations::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('total_top_up_price');

                    $entTax = Ticket::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('ent_tax')
                        +
                        Reservations::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('ent_tax');

                    $vat = Ticket::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('vat')

                        +
                        Reservations::whereBetween('created_at', [$starting_date, $ending_date])
                            ->where('add_by', $user->id)
                            ->where('payment_method', $paymentMethod)
                            ->sum('vat');

                    $total = $totalPrice + $TotalTopUpPrice + $entTax + $vat;

                    if ($total > 0) {
                        $cashierArray[] = [
                            'name' => $user->name,
                            'total_price' => number_format($totalPrice, 2),
                            'total_top_up_price' => ($TotalTopUpPrice),
                            'ent_tax' => number_format($entTax, 2),
                            'vat' => number_format($vat, 2),
                            'total' => number_format($total, 2),
                        ];
                    }
                }
            }

            return Datatables::of($cashierArray)->make(true);
        }

        $events = Event::all();
        $employees = User::all();

        return view('Admin/sales/totalTodaySales', compact('starting_date', 'ending_date', 'events', 'employees', 'request'));

    }


    /**
     * @param Request $request
     * @return void
     */
    public function totalProductsSales(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');


        if ($request->ajax()) {
            $productsModels = TicketRevProducts::with('product')->where('cancel', '=', true)->whereDate('created_at', '>=', $starting_date)
                ->whereDate('created_at', '<=', $ending_date)->with('product')->select('*', DB::raw('SUM(total_price) AS total'),
                    DB::raw('SUM(qty) AS total_qty'))->groupBy('product_id')->get();

            return Datatables::of($productsModels)
                ->addColumn('product', function ($product) {
                    return $product->product->title;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('Admin/sales/totalProductsSales', compact('starting_date', 'ending_date'));

    }//end fun


    public function discountReport(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        $ticketSales = Ticket::where('discount_id', '!=', null)
            ->whereDate('created_at', '>=', $starting_date)
            ->whereDate('created_at', '<=', $ending_date)
            ->with('reason')->where('discount_id', '!=', null);

        if ($request->employee_id != null) {
            $ticketSales = $ticketSales->where('add_by', $request->employee_id);
        }


        if ($request->has('payment_method') && $request->payment_method != '')
            $ticketSales = $ticketSales->where('payment_method', $request->payment_method);

        if ($request->has('payment_status') && $request->payment_status != '')
            $ticketSales = $ticketSales->where('payment_status', $request->payment_status);

        $ticketSales = $ticketSales->get();

        if ($request->ajax()) {
            return Datatables::of($ticketSales)
                ->addColumn('before_discount', function ($ticketSales) {
                    if ($ticketSales->discount_type == 'per') {
//                        return round(($ticketSales->ticket_price + $ticketSales->vat) + ($ticketSales->discount_value / 100 * $ticketSales->ticket_price + $ticketSales->vat), 2);
                        return $ticketSales->total_price;
                    } elseif ($ticketSales->discount_type == 'val')
//                        return $ticketSales->ticket_price + $ticketSales->vat + $ticketSales->discount_value;
                        return $ticketSales->total_price;
                    else
                        return '--';
                })
                ->addColumn('discount_amount', function ($ticketSales) {
                    if ($ticketSales->discount_type == 'per') {
                        return (round($ticketSales->discount_value / 100 * $ticketSales->total_price, 2));
                    } elseif ($ticketSales->discount_type == 'val')
                        return $ticketSales->discount_value;
                    else
                        return '--';
                })
                ->addColumn('discount_reasons', function ($ticketSales) {
                    return ($ticketSales->reason->desc) ?? '--';
                })
                ->addColumn('cashier', function ($ticketSales) {
                    return (User::where('id', $ticketSales->add_by)->first()->name) ?? '---';
                })
                ->escapeColumns([])
                ->make(true);
        }

        $employees = User::all();
        return view('Admin/sales/discountReport', compact('starting_date', 'ending_date', 'employees', 'request'));

    }//end fun


    public function discountReservationsReport(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        $ticketSales = Reservations::with('reason')->where('discount_id', '!=', null)
            ->whereDate('created_at', '>=', $starting_date)
            ->whereDate('created_at', '<=', $ending_date)
            ->latest();

//        return Reservations::latest()->first();

        if ($request->employee_id != null) {
            $ticketSales = $ticketSales->where('add_by', $request->employee_id);
        }

        if ($request->has('payment_method') && $request->payment_method != '')
            $ticketSales = $ticketSales->where('payment_method', $request->payment_method);

        if ($request->has('payment_status') && $request->payment_status != '')
            $ticketSales = $ticketSales->where('payment_status', $request->payment_status);

        $ticketSales = $ticketSales->get();


        if ($request->ajax()) {
            return Datatables::of($ticketSales)
                ->addColumn('before_discount', function ($ticketSales) {
                    if ($ticketSales->discount_type == 'per') {
                        return $ticketSales->total_price;

//                        return ($ticketSales->ticket_price + $ticketSales->vat) + ($ticketSales->discount_value / 100 * $ticketSales->ticket_price + $ticketSales->vat);
                    } elseif ($ticketSales->discount_type == 'val')
                        return $ticketSales->ticket_price + $ticketSales->vat + $ticketSales->discount_value;
                    else
                        return '--';
                })
                ->addColumn('discount_amount', function ($ticketSales) {
                    if ($ticketSales->discount_type == 'per') {
                        return ($ticketSales->discount_value / 100 * $ticketSales->total_price);
                    } elseif ($ticketSales->discount_type == 'val')
                        return $ticketSales->discount_value;
                    else
                        return '--';
                })
                ->addColumn('discount_reasons', function ($ticketSales) {
                    return ($ticketSales->reason->desc) ?? '--';
                })
                ->addColumn('cashier', function ($ticketSales) {
                    return (User::where('id', $ticketSales->add_by)->first()->name) ?? '---';
                })
                ->escapeColumns([])
                ->make(true);
        }
        $employees = User::all();

        return view('Admin/sales/reservationReport', compact('starting_date', 'ending_date', 'request', 'employees'));

    }//end fun

    public function attendanceReport(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $ending_date = date('Y-m-d');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->ajax()) {
            $ticketModels = TicketRevModel::select('visitor_type_id', DB::raw('count(*) as total'))
                ->where('cancel', '=', true)
                ->whereDate('created_at', '>=', $starting_date)
                ->whereDate('created_at', '<=', $ending_date)
                ->groupBy('visitor_type_id')
                ->latest()
                ->get();

            return Datatables::of($ticketModels)
                ->editColumn('visitor_type_id', function ($ticketModels) {
                    return (VisitorTypes::where('id', $ticketModels->visitor_type_id)->first()->title) ?? '--';
                })
                ->escapeColumns([])
                ->make(true);
        }
        $employees = User::all();
        return view('Admin/sales/attendanceReport', compact('starting_date', 'ending_date', 'employees', 'request'));

    }//end fun

    public function repeatedVisitors()
    {
        return view('Admin.sales.repeatedVisitors');
    }

    public function repeatedVisitorsData()
    {
        $clients = Ticket::whereNotNull('client_id')
            ->select('client_id', DB::raw('COUNT(*) as total_visits'))
            ->where('paid_amount', '>', 0)
            ->groupBy('client_id')
            ->havingRaw('COUNT(*) > 1')
            ->with('client')
            ->orderByDesc('total_visits')
            ->get();

        return DataTables::of($clients)
            ->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->name : '---';
            })
            ->addColumn('phone', function ($row) {
                return $row->client && $row->client->phone ? $row->client->phone : '---';
            })
            ->addColumn('total_visits', function ($row) {
                return $row->total_visits;
            })
            ->addColumn('action', function ($row) {
                $phone = $row->client && $row->client->phone ? $row->client->phone : '';
                return '<button class="btn btn-sm btn-info show-dates" data-client-phone="' . e($phone) . '">Show Dates</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getVisitDatesByPhone($phone)
    {
        $dates = Ticket::where('client_id', $phone)
            ->orderByDesc('visit_date')
            ->pluck('visit_date')
            ->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d M Y');
            });

        return response()->json($dates);
    }

    public function durationClients()
        {
            return view('Admin.sales.durationClientsSpent');
        }

    public function durationClientsSpent(Request $request)
    {
        $hoursFilter = $request->input('hours_filter');

        // Get tickets with paid amount > 0 and optional hours_filter
        $ticketsQuery = Ticket::with('client')
            ->where('paid_amount', '>', 0);

        if (!empty($hoursFilter)) {
            $ticketsQuery->where('hours_count', $hoursFilter);
        }

        $ticketsByClient = $ticketsQuery->orderByDesc('visit_date')
            ->get()
            ->groupBy('client_id');

        $data = $ticketsByClient->map(function ($tickets, $clientId) {
            return (object) [
                'client_id' => $clientId,
                'total_hours_spent' => $tickets->pluck('hours_count'),
                'visit_dates' => $tickets->pluck('visit_date'),
                'client' => $tickets->first()->client,
                'tickets' => $tickets,
            ];
        })->values();

        return DataTables::of($data)
            ->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->name : '---';
            })
            ->addColumn('phone', function ($row) {
                return $row->client ? $row->client->phone : '---';
            })
            ->addColumn('total_hours_spent', function ($row) {
                return collect($row->total_hours_spent)->implode('<br>');
            })
            ->addColumn('visit_dates', function ($row) {
                return collect($row->visit_dates)->map(function ($d) {
                    return \Carbon\Carbon::parse($d)->format('d M Y');
                })->implode('<br>');
            })
            ->addColumn('action', function ($row) {
                $phone = $row->client ? $row->client->phone : '';
                return '<button class="btn btn-sm btn-primary details-btn" data-client-phone="' . $phone . '">Details</button>';
            })
            ->rawColumns(['visit_dates', 'action', 'total_hours_spent'])
            ->make(true);
    }


    public function getClientVisitDatesByPhone(Request $request, $phone)
        {
            $tickets = Ticket::with('client')
                ->whereHas('client', fn($q) => $q->where('phone', $phone))
                ->where('paid_amount', '>', 0)
                ->orderByDesc('visit_date')
                ->get();

            $data = $tickets->map(function ($ticket) {
                return [
                    'visit_date' => \Carbon\Carbon::parse($ticket->visit_date)->format('d M Y'),
                    'paid_amount' => $ticket->paid_amount,
                ];
            });

            return response()->json($data);
        }

    public function detailsOfTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $products = TicketRevProducts::where('ticket_id', $ticket->id)->get();
        $models = $ticket->models->groupBy('visitor_type_id');
        return view('sales.layouts.ticket.details', compact('ticket', 'models', 'products'));
    }

    //start reservation detail by islam
    public function detailsOfReservation($id)
    {

        $reservation = Reservations::findOrFail($id);
        $products = TicketRevProducts::where('rev_id', $reservation->id)->get();
        $models = $reservation->models->groupBy('visitor_type_id');
        return view('sales.layouts.reservation.details', compact('reservation', 'products', 'models'));
    }

}
