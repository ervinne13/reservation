<?php

namespace App\Models;

use DateTime;
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

    public function getCurrentDueDate() {
        $latestPayment = $this->latestPayment;

        $currentDate  = new DateTime();
        $dateReceived = new DateTime($this->date_received);

        if ($latestPayment) {
            $lastPaymentDate = new DateTime($latestPayment->document_date);
        } else {
            $lastPaymentDate = $dateReceived;
        }
        
        $lastPaymentDate->modify('+1 month');

        return $lastPaymentDate;
    }

    public function details() {
        return $this->hasMany(AmortizationLoanDetail::class, 'document_number', 'document_number');
    }

    public function loanBy() {
        return $this->belongsTo(Client::class, 'loan_by_username');
    }

    public function payments() {
        return $this->hasMany(RequestPayment::class, 'applies_to');
    }

    public function latestPayment() {
        return $this
                        ->hasOne(RequestPayment::class, 'applies_to')
                        ->orderBy("document_date", "DESC")
                        ->limit(1)
        ;
    }

    public function scopeOpen($query) {
        return $query->where('status', 'Open')->orWhere('status', 'Partially Paid');
    }

    public function scopeOpenAndDocNo($query, $amlDocNo) {
        return $query->where('status', 'Open')
                        ->orWhere('status', 'Partially Paid')
                        ->orWhere('document_number', $amlDocNo);
    }

    public function scopeUsername($query, $username) {
        return $query->where('loan_by_username', $username);
    }

}
