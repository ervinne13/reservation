<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPaymentDetail extends Model {

    protected $fillable = [
        "document_number", "payment_type_code", "amount", "comment"
    ];

}
