<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoice;

class SalesController extends Controller {

    public function index() {

        $viewData = $this->getDefaultViewData();

        $viewData["dailySales"]         = SalesInvoice::getDailySales();
        $viewData["monthlySales"]       = SalesInvoice::getMonthlySales();
        $viewData["monthlyCollections"] = SalesInvoice::getMonthlyCollections();

        return view("pages.sales.index", $viewData);
    }

}
