<?php

namespace App\Repositories;

use App\Models\Pos;
use App\Models\PosHasProduct;
use Carbon\Carbon;

class PosRepository
{
    protected $pos, $pos_has_product;

    public function __construct()
    {
        $this->pos             = new Pos();
        $this->pos_has_product = new PosHasProduct();
    }

    public function getBookings($request)
    {
        $schedule_date = $request->has('date') ? Carbon::parse($request->get('date')) : Carbon::now()->tz('Asia/Kuwait');

        return $this->pos
            ->with('products', 'transactions')
            ->whereDate('created_at', $schedule_date)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getBookingBySlug($slug)
    {
        $booking = $this->pos->with('transactions', 'products.product')->where('slug', $slug)->first();
        if (!isset($booking)) {
            throw new \Exception('No query results for model [App\Models\Booking] ' . $slug, 201);
        }

        return $booking;
    }

    public function getBookingById($id)
    {
        $booking = $this->pos->with('transactions', 'products.product')->where('id', $id)->first();
        if (!isset($booking)) {
            throw new \Exception('No query results for model [App\Models\Booking] ' . $id, 201);
        }

        return $booking;
    }

    public function getBookingByInvoiceNumber($invoice_number)
    {
        $booking = $this->pos->with('transactions', 'products.product')->where('invoice_number', $invoice_number)->first();
        if (!isset($booking)) {
            throw new \Exception('No record found for ' . $invoice_number, 201);
        }

        return $booking;
    }

    public function generateInvoiceNumber()
    {
        return 'AL-' . str_pad(1, 6, '0', STR_PAD_LEFT);
    }

    public function store($data)
    {
        $data['slug']           = generate_slug('pos');
        $data['invoice_number'] = $this->generateInvoiceNumber();

        $pos = $this->pos->create($data);

        $booking_products = !empty($data['booking_products']) ? json_decode($data['booking_products']) : [];
        if (!empty($booking_products)) {
            foreach ($booking_products as $booking_product) {
                $this->pos_has_product
                    ->create([
                        'pos_id'          => $pos->id,
                        'product_id'      => $booking_product->product_id,
                        'quantity'        => $booking_product->quantity ?? 1,
                        'amount'          => $booking_product->amount ?? 0,
                        'discount_type'   => $booking_product->product_discount_type ?? 'fixed',
                        'discount_value'  => (float)($booking_product->product_discount_value ?? 0),
                        'discount_amount' => (float)($booking_product->item_discount_amount ?? 0),
                        'final_amount'    => $booking_product->final_amount ?? 0,
                    ]);
            }
        }

        return [
            'booking_slug'   => $pos->slug,
            'invoice_number' => $pos->invoice_number
        ];
    }

    public function cancelBooking($request)
    {
        $pos = $this->pos
            ->with('products')
            ->where('invoice_number', $request->get('invoice_number'))
            ->first();
        if (!isset($pos)) {
            throw new \Exception('No record found for the given invoice number.', 201);
        }

        if ($pos->status == 'canceled') {
            throw new \Exception('Invoice has already been canceled.', 201);
        }

        if ($pos->final_amount < $request->get('amount')) {
            throw new \Exception('You can not refund more than paid amount', 201);
        }

        $this->pos
            ->where('id', $pos->id)
            ->update([
                'status'        => 'canceled',
                'refund_amount' => $request->get('amount'),
                'updated_by'    => auth()->user()->id
            ]);
    }
}
