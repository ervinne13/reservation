<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class NumberSeries extends Model {

    protected $primaryKey = "code";
    public $incrementing  = false;

    public static function get($NSCode) {
        $ns = NumberSeries::find($NSCode);

        if ($ns) {
            $incrementedNumber = $ns->last_number_used + 1;
            $newNS             = "{$NSCode}-{$incrementedNumber}";

            $ns->last_number_used = $incrementedNumber;
            $ns->save();

            return $newNS;
        } else {
            throw new Exception("Number series code not found!");
        }
    }

}
