<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Item;
use App\Models\NotifyPhoneNumber;
use App\Models\SalesInvoice;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    public function index() {
        if (Auth::check()) {
            $viewData                 = $this->getDefaultViewData();
            $viewData["phoneNumbers"] = NotifyPhoneNumber::all();
            $viewData["bankAccounts"] = BankAccount::all();

            $viewData["salesSummary"] = SalesInvoice::getSummaryReports();
            $viewData["itemsSummary"] = Item::getSummaryReports();

            return view('pages.home.index', $viewData);
        } else {
            return view('welcome');
        }
    }

}
