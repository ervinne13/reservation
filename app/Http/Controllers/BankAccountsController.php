<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountsController extends Controller {

    public function getAllJSON() {
        return BankAccount::all();
    }

    public function store(Request $request) {

        try {

            $bankAccount = new BankAccount($request->toArray());
            $bankAccount->save();

            return $bankAccount;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id) {

        try {

            $bankAccount = BankAccount::find($id);
            $bankAccount->fill($request->toArray());
            $bankAccount->save();

            return $bankAccount;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

}
