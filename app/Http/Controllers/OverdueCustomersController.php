<?php

namespace App\Http\Controllers;

use App\Models\AmortizationLoan;

class OverdueCustomersController extends Controller {

    public function index() {

        $viewData              = $this->getDefaultViewData();
        $viewData["openLoans"] = AmortizationLoan::open()->get();

//        return $viewData["openLoans"][0]->getCurrentDueDate()->format("Y-m-d");
        
        return view('pages.overdue-customers.index', $viewData);
    }

}
