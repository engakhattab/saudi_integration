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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
{
    public function index(request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');


        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');

//        $tickets_1 = Ticket::whereHas('models', function ($model) use($starting_time,$ending_time){
//            $model->where('shift_start','>=',$starting_time)
//                ->where('shift_end','<=',$ending_time);
//        })->latest()->where('visit_date', '>=', $starting_date)
//            ->where('visit_date', '<=', $ending_date);


        if ($request->ajax()) {

            $tickets = Ticket::latest();


            if ($request->has('payment_method') && $request->payment_method != '')
                $tickets->where('payment_method', $request->payment_method);

//            if ($request->has('starting_time') && $request->starting_time != '')
//                $tickets->whereHas('models', function ($model) use ($starting_time) {
//                    $model->whereTime('shift_start', '>=', $starting_time);
//                });

            if ($request->has('ending_time') && $request->ending_time != '') {

                //                $tickets->whereHas('models', function ($model) use ($ending_time) {
//                    $model->whereTime('created_at', '<=', $ending_time);
                    $tickets->where('created_at', '>=' ,$starting_time)->where('created_at', '<=' , $ending_time)
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
                    return ($tickets->created_at->format('Y-m-d H:i:s')) ?? '---';
                })
                ->addColumn('ticket_types', function ($tickets) {
                    return '<span style="cursor:pointer" class="icon btn btn-info showSpan" data-bs-toggle="tooltip" title=" details " data-id="' . $tickets->id . '">Show <i class="fa fa-eye"></i></span>';
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
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');


        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');


        if ($request->ajax()) {
            $tickets = Ticket::latest()->whereDate('created_at', '=', date('Y-m-d'));

            if ($request->has('payment_method') && $request->payment_method != '')
                $tickets->where('payment_method', $request->payment_method);

//            if ($request->has('starting_time') && $request->starting_time != '')
//                $tickets->whereHas('models', function ($model) use ($starting_time) {
//                    $model->where('shift_start', '>=', $starting_time);
//                });

//            if ($request->has('ending_time') && $request->ending_time != '') {
//
//                $tickets->where('created_at', '>=' ,$starting_time)->where('created_at', '<=' , $ending_time)
//                    ->where(function ($query) use ($starting_time, $ending_time) {
//                        $query->where('created_at', '>=', $starting_time)
//                            ->where('created_at', '<=', $ending_time);
//                    });
//            }

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
            return view('Admin/sales/cancel', compact('starting_date', 'ending_date', 'events', 'employees', 'request', 'starting_time', 'ending_time'));
        }
    }//end fun

    public function cancelUpdateMethod(Request $request)
    {

        $ticket = Ticket::where('id', '=', $request->id)->first();
        $ticket->update(['total_price' => 0, 'total_top_up_price' => 0, 'total_top_down_price' => 0, 'discount_value' => 0, 'ticket_price' => 0, 'grand_total' => 0, 'paid_amount' => 0, 'rem_amount' => 0, 'vat' => 0]);

        $ids = TicketRevModel::where('ticket_id', '=', $request->id)->pluck('id');
        foreach ($ids as $id) {
            TicketRevModel::where('id', $id)->update(['price' => 0, 'cancel' => 0, 'top_up_price' => 0]);
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

    /*
     * end of cancel Ticket
     */

    public function reservationSale(request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');

        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');


        if ($request->ajax()) {
            $reservations = Reservations::latest()->where('created_at', '>=', $starting_time)
                ->where('created_at', '<=', $ending_time)
                ->orWhereDay('created_at', Carbon::now()->format('d'));


            if ($request->has('payment_method') && $request->payment_method != '')
                $reservations->where('payment_method', $request->payment_method);

//            if ($request->has('starting_time') && $request->starting_time != '')
//                $reservations->whereHas('models', function ($model) use ($starting_time) {
//                    $model->where('shift_start', '>=', $starting_time);
//                });

            if ($request->has('ending_time') && $request->ending_time != '') {

                $reservations->whereHas('models', function ($model) use ($ending_time, $starting_time) {
                    $model
//                        ->whereBetween('created_at', [$starting_time, $ending_time])
                        ->where(function ($query) use ($starting_time, $ending_time) {
                            $query->where('created_at', '>=', $starting_time)
                                ->where('created_at', '<=', $ending_time);
                        });
                });
            }

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
                    return '<span style="cursor:pointer" class="icon btn btn-info showSpan" data-bs-toggle="tooltip" title=" details " data-id="' . $reservations->id . '">Show <i class="fa fa-eye"></i></span>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            $events = Event::all();
            $employees = User::all();
            return view('Admin/sales/reservations', compact('starting_date', 'request', 'ending_date', 'events', 'employees', 'starting_time', 'ending_time'));
        }
    }//ene fun

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productSales(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');

        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');

        if ($request->ajax()) {
            $tickets = Ticket::latest()->where('created_at', '>=', $starting_time)
                ->where('created_at', '<=', $ending_time);

            if ($request->has('payment_method') && $request->payment_method != '')
                $tickets->where('payment_method', $request->payment_method);

//            if ($request->has('starting_time') && $request->starting_time != '')
//                $tickets->whereHas('models', function ($model) use ($starting_time) {
//                    $model->where('shift_start', '>=', $starting_time);
//                });

            if ($request->has('ending_time') && $request->ending_time != '') {

                $tickets->where('created_at', '>=' ,$starting_time)->where('created_at', '<=' , $ending_time)
                    ->where(function ($query) use ($starting_time, $ending_time) {
                        $query->where('created_at', '>=', $starting_time)
                            ->where('created_at', '<=', $ending_time);
                    });
            }

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

//            if ($request->has('starting_time') && $request->starting_time != '')
//                $reservations->whereHas('models', function ($model) use ($starting_time) {
//                    $model->where('shift_start', '>=', $starting_time);
//                });

            if ($request->has('ending_time') && $request->ending_time != '')
                $reservations->whereHas('models', function ($model) use ($ending_time,$starting_time) {
                    $model->where('created_at', '>=' ,$starting_time)->where('created_at', '<=' , $ending_time)
                        ->where(function ($query) use ($starting_time, $ending_time) {
                            $query->where('created_at', '>=', $starting_time)
                                ->where('created_at', '<=', $ending_time);
                        });
                });

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
        return view('Admin/sales/productSales', compact('starting_date', 'ending_date', 'events', 'employees', 'request', 'ending_time', 'starting_time'));


    }//end fun


    public function totalCashierSales(Request $request)
    {
//        dd($request->all());

        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');

        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');
        $ending_time = date("Y-m-d H:i:s", strtotime($ending_time));
        $starting_time = date("Y-m-d H:i:s", strtotime($starting_time));
//        dd($ending_time);

        if ($request->ajax()) {
            $request->all();
//            dd($request->all());
            $users = User::all();

            $users = Payment::select('id','cashier_id')->with('cashier')->groupBy('cashier_id')->get();
//            dd($users);
            $paymentMethods = ['cash', 'visa', 'mastercard', 'Meeza', 'voucher'];

            $cashierArray = [];
            foreach ($users as $user) {
                foreach ($paymentMethods as $paymentMethod) {
                    $oneCashier = [];
                    $oneCashier['name'] = @$user->cashier->name ?? "User deleted";
//                    $pMethod = $request->payment_method ?? $paymentMethod;
                    $oneCashier['payment_method'] = $paymentMethod;
                    $totalRev = 0;
                    $totalTicket = 0;
//                    $reservation = Payment::latest()->where('day', '>=', $starting_date)
//                        ->where('day', '<=', $ending_date);
                    $reservation = Payment::latest()->whereBetween('created_at', [$starting_time, $ending_time]);
//                        ->whereBetween('created_at', [$starting_time, $ending_time])
//                        ->where(function ($query) use ($starting_time, $ending_time) {
//                            $query->whereBetween('created_at', [$starting_time, $ending_time]);
//                        });

                    if ($request->has('payment_method') && $request->payment_method != '')
                        $reservation->where('payment_method', $request->payment_method);

//                    if ($request->has('starting_time') && strtotime($request->starting_time))
//                        $reservation->whereTime('created_at', '>=', $request->starting_time);
//
//
//                    if ($request->has('ending_time') && strtotime($request->ending_time))
//                        $reservation->whereTime('created_at', '<=', $request->ending_time);


                    if ($request->has('employee_id') && $request->employee_id != '')
                        $reservation->where('cashier_id', $request->employee_id);

                    $totalRev = $reservation

                        ->where('cashier_id', $user->cashier_id)

                        ->where('payment_method', $paymentMethod)
                        ->sum('amount');

                    $ticket = ReturnAmount::latest()->whereBetween('created_at', [$starting_time, $ending_time]);

                    if ($request->has('payment_method') && $request->payment_method != '')
                        $ticket->where('payment_method', $request->payment_method);


                    if ($request->has('employee_id') && $request->employee_id != '')
                        $ticket->where('cashier_id', $request->employee_id);

                    $totalTicket = $ticket->where('cashier_id', $user->cashier_id)->where('payment_method', $paymentMethod)->sum('amount');
                    $oneCashier['total'] =  $totalRev - $totalTicket;
                    $cashierArray[] = $oneCashier ;
//                    echo $totalRev;
                }
            }

//            dd($cashierArray);

            foreach ($cashierArray as $key => $item) {
                if ($item['total'] == 0)
                    unset($cashierArray[$key]);

            }

//            dd($cashierArray);

            return Datatables::of($cashierArray)
                ->escapeColumns([])
                ->make(true);

        }
        $events = Event::all();
        $employees = User::all();
        return view('Admin/sales/totalCashierSales', compact('starting_date', 'ending_date', 'events', 'employees', 'request', 'starting_time', 'ending_time'));

    }//end fun

    /**
     * @param Request $request
     * @return void
     */
    public function totalProductsSales(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');


        if ($request->ajax()) {
            $productsModels = TicketRevProducts::with('product')
                ->where('cancel', '=', true)
                ->whereBetween('created_at', [$starting_time, $ending_time])
                ->where(function ($query) use ($starting_time, $ending_time) {
                    $query->where('created_at', '>=', $starting_time)
                        ->where('created_at', '<=', $ending_time);
                })
                ->with('product')->select('*', DB::raw('SUM(total_price) AS total'),
                    DB::raw('SUM(qty) AS total_qty'))->groupBy('product_id')->get();

            return Datatables::of($productsModels)
                ->addColumn('product', function ($product) {
                    return $product->product->title;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('Admin/sales/totalProductsSales', compact('starting_date', 'ending_date', 'starting_time', 'ending_time'));

    }//end fun


    public function discountReport(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');


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

//        if ($request->has('starting_time') && $request->starting_time != '')
//            $ticketSales->whereHas('models', function ($model) use ($starting_time) {
//                $model->where('shift_start', '>=', $starting_time);
//            });

        if ($request->has('ending_time') && $request->ending_time != '') {

            $ticketSales->where('created_at', '>=' ,$starting_time)->where('created_at', '<=' , $ending_time)
                ->where(function ($query) use ($starting_time, $ending_time) {
                    $query->where('created_at', '>=', $starting_time)
                        ->where('created_at', '<=', $ending_time);
                });
        }

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
        return view('Admin/sales/discountReport', compact('starting_date', 'ending_date', 'employees', 'request', 'starting_time', 'ending_time'));

    }//end fun


    public function discountReservationsReport(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->has('starting_time') && strtotime($request->starting_time))
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && strtotime($request->ending_time))
            $ending_time = $request->get('ending_time');

        $ticketSales = Reservations::with('reason')->where('discount_id', '!=', null)
            ->where('created_at', '>=', $starting_time)
            ->where('created_at', '<=', $ending_time)
//            ->whereHas('models', function ($model) use ($ending_time, $starting_time) {
//                $model
////                    ->whereBetween('created_at', [$starting_time, $ending_time])
//                    ->where(function ($query) use ($starting_time, $ending_time) {
//                        $query->where('created_at', '>=', $starting_time)
//                            ->where('created_at', '<=', $ending_time);
//                    });
//            })
//            ->whereHas('models', function ($model) use ($ending_time) {
//                $model->where('shift_start', '>=', $ending_time);
//            })
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

        return view('Admin/sales/reservationReport', compact('starting_date', 'ending_date', 'request', 'employees', 'ending_time', 'starting_time'));

    }//end fun

    public function attendanceReport(Request $request)
    {
        $starting_date = date('Y-m-d', strtotime(date('Y-m-d') . '-1 month'));
        $ending_date = date('Y-m-d');
        $starting_time = date('Y-m-d H:i:s');
        $ending_time = date('Y-m-d H:i:s');


        if ($request->has('starting_date') && strtotime($request->starting_date))
            $starting_date = $request->get('starting_date');


        if ($request->has('ending_date') && strtotime($request->ending_date))
            $ending_date = $request->get('ending_date');

        if ($request->has('starting_time') && $request->starting_time != '')
            $starting_time = $request->get('starting_time');


        if ($request->has('ending_time') && $request->ending_time != '')
            $ending_time = $request->get('ending_time');

        if ($request->ajax()) {
            $ticketModels = TicketRevModel::select('visitor_type_id', DB::raw('count(*) as total'))
                ->where('cancel', '=', true)
//                ->whereDate('created_at', '>=', $starting_date)
//                ->whereDate('created_at', '<=', $ending_date)
//                ->whereBetween('created_at', [$starting_time, $ending_time])
                ->where(function ($query) use ($starting_time, $ending_time) {
                    $query->where('created_at', '>=', $starting_time)
                        ->where('created_at', '<=', $ending_time);
                })
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
        return view('Admin/sales/attendanceReport', compact('starting_date', 'ending_date', 'employees', 'request', 'starting_time', 'ending_time'));

    }//end fun

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
