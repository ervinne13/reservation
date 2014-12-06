<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;

class BankAccountsController extends Controller {

    public function getAllJSON() {
        return BankAccount::all();
    }

}
