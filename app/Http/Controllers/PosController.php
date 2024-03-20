<?php

namespace App\Http\Controllers;

use App\Repositories\PosRepository;
use App\Repositories\ProductCategoriesRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PosController extends Controller
{
    protected $pos_repository, $product_categories_repository, $products_repository, $users_repository;

    public function __construct()
    {
        $this->pos_repository                = new PosRepository();
        $this->product_categories_repository = new ProductCategoriesRepository();
        $this->products_repository           = new ProductsRepository();
        $this->users_repository              = new UsersRepository();
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
        $organization = $this->organization->where('id', session()->get('organization_id'))->first();
        $user_group   = auth()->user()->group->name;
        if ($request->ajax()) {
            $data = $this->pos_repository->getBookings($request);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->tz('Asia/Kuwait')->format('d F, Y h:i A');
                })
                ->addColumn('paid', function ($row) {
                    if ($row->status == 'canceled') {
                        return 0.000;
                    }
                    return number_format((float)($row->final_amount - $row->remaining_amount), 3, '.', '');
                })
                ->addColumn('customer_phone', function ($row) use ($organization, $user_group) {
                    return $user_group == 'Workers' && $organization->is_phone_display ? $row->customer->phone : ($user_group == 'Workers' && !$organization->is_phone_display ? '*******' : $row->customer->phone);
                })
                ->addColumn('remaining_amount', function ($row) {
                    if ($row->status == 'canceled') {
                        return 0.000;
                    }
                    return number_format((float)$row->remaining_amount, 3, '.', '');
                })
                ->editColumn('final_amount', function ($row) {
                    return number_format((float)($row->final_amount), 3, '.', '');
                })
                ->addColumn('action', function ($row) {
                    $output = '
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu actions_button" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="' . route('pos.show', [$row->slug]) . '">
                                    <i class="fa fa-eye"></i> &nbsp; ' . __("locale.show") . '
                                </a>
                                <a class="dropdown-item print_invoice" href="javascript:void(0);" data-booking-slug="' . $row->invoice_number . '">
                                    <i class="fa fa-file-invoice"></i> &nbsp;  ' . __("locale.print_invoice") . '
                                </a>';

                    if ($row->status !== 'canceled' && $row->remaining_amount > 0) {
                        $title  = 'Remaining Amount: <br><br> KD ' . number_format((float)$row->remaining_amount, 3, '.', '');
                        $output .= '
                                <a class="dropdown-item receive_payment" href="javascript:void(0);" data-remaining-amount="' . $row->remaining_amount . '" data-title="' . $title . '" data-booking-slug="' . $row->slug . '" data-href="' . route('pos.receive.payment') . '">
                                    <i class="fa fa-money-bill-alt"></i>&nbsp;  ' . __("locale.receive_payment") . '
                                </a>';
                    }

                    if ($row->status !== 'canceled') {
                        $output .= '
                                <a class="dropdown-item cancel_booking" href="javascript:void(0);" data-final-amount="' . ($row->final_amount - $row->remaining_amount) . '" data-booking-slug="' . $row->invoice_number . '" data-href="' . route('pos.cancel_booking') . '" data-password-href="' . route('users.check_cancel_invoice_password') . '">
                                    <i class="fa fa-times"></i>&nbsp;  ' . __("locale.cancel_booking") . '
                                </a>
                                <a class="dropdown-item update_status" href="javascript:void(0);" data-booking-slug="' . $row->slug . '" data-booking-status="' . $row->status . '" data-href="' . route('pos.update_status') . '">
                                    <i class="fa fa-sync"></i>&nbsp;  ' . __("locale.update_status") . '
                                </a>';
                    }

                    $output .= '
                            </div>
                        </div>';

                    return $output;
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
            $data['created_from'] = 'pos';
            if ($data['booking_id'] > 0) {
                $pos_response = $this->pos_repository->update($data);
            } else {
                $pos_response = $this->pos_repository->store($data);
            }

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
            $booking_data  = $this->pos_repository->getBookingBySlug($slug);
            $payment_types = $this->payment_type->where('organization_id', session()->get('organization_id'))->where('is_active', 1)->pluck('name', 'id')->toArray();
            return view('pos.show', compact('booking_data', 'payment_types'));
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
            $local_value        = Session::get('locale');
            $configuration_data = get_configurations_data('invoice_language', session()->get('organization_id'));
            $config_locale      = $configuration_data['invoice_language'];
            app()->setLocale($config_locale);
            $booking       = $this->pos_repository->getBookingByInvoiceNumber($request->get('invoice_number'));
            $rendered_html = view('pos.print.invoice', compact('booking', 'config_locale'))->render();
            app()->setLocale($local_value);
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

    public function cancelBooking(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->pos_repository->cancelBooking($request);

            DB::commit();
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Booking has been canceled.'
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

    public function receivePayment(Request $request)
    {
        try {
            $this->pos_repository->receivePayment($request);

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Payment has been received.'
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

    public function validateCoupon(Request $request)
    {
        try {
            $coupon = $this->pos_repository->validateCoupon($request);
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Coupon has been validated',
                'data'    => [
                    'coupon' => [
                        'type'      => !empty($coupon->type) && in_array($coupon->type, ['percentage', 'absolute']) ? $coupon->type : 'absolute',
                        'value'     => $coupon->value > 0 ? $coupon->value : 0,
                        'coupon_id' => isset($coupon->id) ? $coupon->id : 0
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function validateVoucher(Request $request)
    {
        try {
            $voucher = $this->pos_repository->validateVoucher($request);
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Voucher has been validated',
                'data'    => [
                    'voucher' => $voucher
                ]
            ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function updatePaymentType(Request $request)
    {
        try {
            $this->pos_repository->updatePaymentType($request->all());
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Payment type has been updated'
            ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function updateBookingStatus(Request $request)
    {
        try {
            $this->pos_repository->updateBookingStatus($request);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
        return response()
            ->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Booking has been updated.'
            ]);
    }

    public function getCalendarBookingData(Request $request)
    {
        $booking_id   = $request->get('booking_id', 0);
        $booking_data = $this->pos_repository->getBookingById($booking_id);

        $final_array = [];
        foreach ($booking_data->items as $key => $value) {
            $commission_data = [];
            foreach ($value->staff as $staff_value) {
                $commission_data[] = [
                    'worker_id'           => $staff_value->worker_id,
                    'worker_name'         => $staff_value->worker->name,
                    'worker_commission'   => $staff_value->commission_amount,
                    'is_supporting_staff' => $staff_value->is_supporting_staff
                ];
            }
            $final_array[] = [
                'type'                 => 'service',
                'item_id'              => $value->itemable_id,
                'quantity'             => $value->quantity,
                'price'                => $value->per_item_cost,
                'expiry_days'          => 0,
                'final_cost'           => $value->final_cost ?? 0,
                'item_name'            => $value->itemable->name ?? '-',
                'item_discount_type'   => 'fixed',
                'item_discount_value'  => 0,
                'item_discount_cost'   => 0,
                'item_discount_cost'   => 0,
                'service_type'         => $value->pos->service_type,
                'schedule_date'        => $value->schedule_date,
                'schedule_time'        => $value->schedule_time,
                'voucher_value'        => 0,
                'selected_worker_id'   => $value->worker_id,
                'selected_worker_name' => $value->worker->name,
                'is_package'           => 0,
                'package_id'           => 0,
                'package_id'           => 0,
                'notes'                => null,
                'commission_data'      => $commission_data
            ];
        }
        return response()
            ->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Booking details have been retrieved.',
                'data'    => [
                    'item_data'    => $final_array,
                    'booking_data' => $booking_data
                ]
            ]);
    }
}
