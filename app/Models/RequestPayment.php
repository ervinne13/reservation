<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RequestPayment extends Model {

    protected $primaryKey = "document_number";
    public $incrementing  = false;
    protected $fillable   = [
        "document_number", "document_date", "applies_to", "due_date", "total_payment", "issued_by_username", "payment_by_username", "payment_by_name", "payment_by_address", "remarks"
    ];

    public static function make() {
        $rp                     = new RequestPayment();
        $rp->document_number    = NumberSeries::get("RP");
        $rp->document_date      = date('Y-m-d');
        $rp->status             = "Open";
        $rp->issued_by_username = Auth::user()->username;
        $rp->details            = [];
        return $rp;
    }

    function details() {
        return $this->hasMany(RequestPaymentDetail::class, 'document_number', 'document_number');
    }

    function paymentBy() {
        return $this->belongsTo(Client::class, 'payment_by_username');
    }

}
