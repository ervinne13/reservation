<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $fillable = [
        "model", "name", "cost", "stock", "description", "image_url"
    ];

}
