<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    protected $fillable   = [
        "username", "is_active", "is_delinquent", "full_name", "contact_number_1", "contact_number_2", "landline_number", "address"
    ];
    protected $primaryKey = "username";
    public $incrementing  = false;

    public function loans() {
        return $this->hasMany(AmortizationLoan::class, "loan_by_username");
    }

}
