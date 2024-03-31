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
            ->with('products')
            ->whereDate('created_at', $schedule_date)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getBookingBySlug($slug)
    {
        $booking = $this->pos->with('products.product')->where('slug', $slug)->first();
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
        return 'SAN-' . str_pad(1, 6, '0', STR_PAD_LEFT);
    }

    public function store($data)
    {
        $data['slug']           = generate_slug('pos');
        $data['invoice_number'] = $this->generateInvoiceNumber();

        $pos = $this->pos->create($data);

        $pos_items = !empty($data['pos_items']) ? json_decode($data['pos_items']) : [];
        if (!empty($pos_items)) {
            foreach ($pos_items as $pos_item) {
                $this->pos_has_product
                    ->create([
                        'pos_id'         => $pos->id,
                        'product_id'     => $pos_item->product_id,
                        'quantity'       => $pos_item->quantity ?? 1,
                        'per_item_price' => $pos_item->per_item_price ?? 0,
                        'final_price'    => $pos_item->final_price ?? 0,
                        'product_data'   => json_encode($pos_item)
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
