<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Item;
use App\Models\NotifyPhoneNumber;
use App\Models\Reservation;
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

            $viewData["clientReservations"] = Reservation::getReservationsByClient();

            $viewData["currentYear"]  = date('Y');
            $viewData["currentMonth"] = date("F");

            return view('pages.home.index', $viewData);
        } else {
            return view('welcome');
        }
    }

}
