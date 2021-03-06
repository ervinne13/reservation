<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model {

    protected $fillable = [
        "reserved_by_username",
        "sales_invoice_no",
        "item_id_to_reserve",
        "reservation_amount",
        "qty_to_reserve",
        "terms",
        "preferred_payment",
        "status"
    ];

    public static function getReservationsByClient() {

        $queryString = "SELECT full_name AS client_name, count(item_id_to_reserve) AS reservation_count FROM reservations 
                        LEFT JOIN clients ON reservations.reserved_by_username = clients.username
                        GROUP BY full_name";

        return DB::select(DB::raw($queryString));
    }

    public function scopeByActiveUsers($query) {
        return $query
                        ->join("users", 'users.username', '=', 'reservations.reserved_by_username')
                        ->where("users.is_active", 1);
    }

    public function scopeReservedByUsername($query, $username) {
        return $query->where("reserved_by_username", $username);
    }

    public function item() {
        return $this->belongsTo(Item::class, "item_id_to_reserve");
    }

    public function salesInvoice() {
        return $this->belongsTo(SalesInvoice::class, "sales_invoice_no");
    }

    public function reservedBy() {
        return $this->belongsTo(Client::class, 'reserved_by_username');
    }

    public function createSI() {

        $salesInvoice                     = SalesInvoice::make();
        $salesInvoice->down_payment       = $this->reservation_amount * $this->qty_to_reserve;
        $salesInvoice->issued_to_username = $this->reserved_by_username;
        $salesInvoice->issued_to_name     = $this->reservedBy->full_name;
        $salesInvoice->issued_to_address  = $this->reservedBy->address;

        $salesInvoiceDetail                  = new SalesInvoiceDetail();
        $salesInvoiceDetail->document_number = $salesInvoice->document_number;
        $salesInvoiceDetail->item_id         = $this->item_id_to_reserve;
        $salesInvoiceDetail->item_model      = $this->item->model;
        $salesInvoiceDetail->item_name       = $this->item->name;
        $salesInvoiceDetail->item_cost       = $this->item->cost;
        $salesInvoiceDetail->item_qty        = $this->qty_to_reserve;
        $salesInvoiceDetail->sub_total       = $this->item->cost;

        unset($salesInvoice->details);

        $salesInvoice->total_amount = $this->item->cost * $this->qty_to_reserve;
        $salesInvoice->save();

        $salesInvoiceDetail->save();

        //  update stocks
        $item = Item::find($salesInvoiceDetail->item_id);
        $item->stock--;
        $item->save();

        $salesInvoice->details = [$salesInvoiceDetail];

        $this->sales_invoice_no = $salesInvoice->document_number;
        $this->status           = "With Sales Invoice";
        $this->save();

        return $salesInvoice;
    }

}
