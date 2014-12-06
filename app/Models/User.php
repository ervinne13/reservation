<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    const ROLE_ADMIN      = "ADMIN";
    const ROLE_SECRETARY  = "SECRETARY";
    const ROLE_ACCOUNTANT = "ACCOUNTANT";
    const ROLE_CLIENT     = "CLIENT";

    protected $primaryKey = "username";
    public $incrementing  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 'username', 'role_name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateAPIToken() {
        $this->api_token = \Hash::make($this->username . $this->password);
    }

}
