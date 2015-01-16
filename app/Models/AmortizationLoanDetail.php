<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmortizationLoanDetail extends Model {

    protected $primaryKey = "line_number";
    public $timestamps    = false;

    public function payment() {
        return $this->belongsTo(RequestPayment::class, "payment_document_number");
    }

}
