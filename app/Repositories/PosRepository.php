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
        $schedule_date = $request->has('schedule_date') ? Carbon::parse($request->get('schedule_date')) : Carbon::now()->tz('Asia/Kuwait');

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
        $booking = $this->pos->with('products.product')->where('id', $id)->first();
        if (!isset($booking)) {
            throw new \Exception('No query results for model [App\Models\Booking] ' . $id, 201);
        }

        return $booking;
    }

    public function getBookingByInvoiceNumber($invoice_number)
    {
        $booking = $this->pos->with('products.product')->where('invoice_number', $invoice_number)->first();
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
}
