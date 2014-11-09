<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceDetail extends Model {

    protected $primaryKey = "line_number";
    protected $fillable   = [
        "document_number", "item_id", "item_model", "item_name", "item_cost", "item_qty", "sub_total"
    ];

}
