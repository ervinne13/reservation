<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {

    protected $primaryKey = "account_number";
    public $incrementing  = false;
    public $timestamps    = false;
    protected $fillable = [
        "account_number", "account_name"
    ];

}
