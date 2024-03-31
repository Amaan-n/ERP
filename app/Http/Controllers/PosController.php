<?php

namespace App\Http\Controllers;

use App\Repositories\PosRepository;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PosController extends Controller
{
    protected $pos_repository, $products_repository;

    public function __construct()
    {
        $this->pos_repository      = new PosRepository();
        $this->products_repository = new ProductsRepository();
    }

    public function index(Request $request)
    {
        try {
            return view('pos.index');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('pos.index')
                ->with('notification', $notification);
        }
    }

    public function getBookings(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->pos_repository->getBookings($request);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->tz('Asia/Kuwait')->format('d F, Y h:i A');
                })
                ->addColumn('customer_name', function ($row) {
                    return $row->customer->name ?? '';
                })
                ->addColumn('customer_phone', function ($row) {
                    return $row->customer->phone ?? '';
                })
                ->editColumn('invoice_amount', function ($row) {
                    return number_format((float)($row->invoice_amount), 3, '.', '');
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu actions_button" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="' . route('pos.show', [$row->slug]) . '">
                                                <i class="fa fa-eye mr-3"></i> Show
                                            </a>
                                            <a class="dropdown-item print_invoice" href="javascript:void(0);" data-booking-slug="' . $row->invoice_number . '">
                                                <i class="fa fa-file-invoice mr-3"></i> Print Invoice
                                            </a>
                                        </div>
                                    </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function create()
    {
        $invoice_number = $this->pos_repository->generateInvoiceNumber();
        return view('pos.manage', compact('invoice_number'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array('customer_id' => 'required'));
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $pos_response = $this->pos_repository->store($data);

            DB::commit();
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Booking has been created.',
                    'data'    => $pos_response
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()
                ->json([
                    'success' => false,
                    'code'    => 201,
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function show($slug)
    {
        try {
            $booking = $this->pos_repository->getBookingBySlug($slug);
            return view('pos.show', compact('booking'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('pos.index')
                ->with('notification', $notification);
        }
    }

    public function getItems(Request $request)
    {
        $data  = $request->all();
        $items = $this->products_repository->getProducts($data);
        if (!empty($items) && count($items) > 0) {
            foreach ($items as $item) {
                if (empty($item->attachment)) {
                    $item->attachment = asset('images/placeholder.jpg');
                }
            }
        }

        $rendered_items_html = view('pos.partials.items', compact('items', 'data'))->render();

        return response()
            ->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Items have been retrieved.',
                'data'    => [
                    'items_html' => $rendered_items_html,
                ]
            ]);
    }

    public function printInvoice(Request $request)
    {
        try {
            $booking       = $this->pos_repository->getBookingByInvoiceNumber($request->get('invoice_number'));
            $rendered_html = view('pos.partials.print_invoice', compact('booking'))->render();
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Invoice HTML has been retrieved for printing.',
                    'data'    => [
                        'html' => $rendered_html
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => 201,
                    'message' => $e->getMessage()
                ]);
        }
    }
}
