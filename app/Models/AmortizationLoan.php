<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AmortizationLoan extends Model {

    protected $primaryKey = "document_number";
    public $incrementing  = false;
    protected $fillable   = [
        "document_number", "document_date", "reference_invoice_number", "loan_by_username", "loan_amount", "date_received", "remaining_amount", "annual_interest_rate", "prevailing_interest_rate", "months_to_pay", "estimated_monthly_principal", "estimated_monthly_interest", "date_recieved", "remarks"
    ];

    public static function make() {
        $aml                     = new AmortizationLoan();
        $aml->document_number    = NumberSeries::get("AML");
        $aml->document_date      = date('Y-m-d');
        $aml->status             = "Open";
        $aml->issued_by_username = Auth::user()->username;
        $aml->details            = [];
        return $aml;
    }

    function details() {
        return $this->hasMany(AmortizationLoanDetail::class, 'document_number', 'document_number');
    }

    function loanBy() {
        return $this->belongsTo(Client::class, 'loan_by_username');
    }

    function scopeOpen($query) {
        return $query->where('status', 'Open')->orWhere('status', 'Partially Paid');
    }

    function scopeOpenAndDocNo($query, $amlDocNo) {
        return $query->where('status', 'Open')
                        ->orWhere('status', 'Partially Paid')
                        ->orWhere('document_number', $amlDocNo);
    }

}
