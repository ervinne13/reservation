<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SalesInvoice extends Model {

    protected $primaryKey = "document_number";
    public $incrementing  = false;
    protected $fillable   = [
        "document_number", "document_date", "total_amount", "down_payment", "issued_by_username", "issued_to_username", "issued_to_name", "issued_to_address", "remarks"
    ];

    public static function make() {
        $si                     = new SalesInvoice();
        $si->document_number    = NumberSeries::get("SI");
        $si->document_date      = date('Y-m-d');
        $si->status             = "Open";
        $si->issued_by_username = Auth::user()->username;
        $si->details            = [];
        return $si;
    }

    function details() {
        return $this->hasMany(SalesInvoiceDetail::class, 'document_number', 'document_number');
    }

    function issuedTo() {
        return $this->belongsTo(Client::class, 'issued_to_username');
    }

    function issuedBy() {
        return $this->belongsTo(User::class, 'issued_by_username');
    }

    function scopeOpen($query) {
        return $query->where('status', 'Open');
    }

    function scopeOpenAndDocNo($query, $siDocNo) {
        return $query->where('status', 'Open')->orWhere('document_number', $siDocNo);
    }

}
