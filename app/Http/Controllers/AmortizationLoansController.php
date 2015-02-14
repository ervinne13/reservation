<?php

namespace App\Http\Controllers;

use App\Models\AmortizationLoan;
use App\Models\SalesInvoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class AmortizationLoansController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {        
        $viewData = $this->getDefaultViewData();
        return view('pages.amortization-loans.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(AmortizationLoan::query())->make(true);
    }

    public function getByUserJSON($username) {
        return AmortizationLoan::With('details')->username($username)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $viewData         = $this->getDefaultViewData();
        $viewData["aml"]  = AmortizationLoan::make();
        $viewData["mode"] = "ADD";

        return view('pages.amortization-loans.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            DB::beginTransaction();

            $aml = new AmortizationLoan($request->toArray());
            $aml->save();

            $si = SalesInvoice::find($aml->reference_invoice_number);

            if ($si) {
                $si->status = "With AML";
                $si->save();
            } else {
                throw new Exception("Sales Invoice of AML Not Found");
            }

            DB::commit();
            return $aml;
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $docNo
     * @return Response
     */
    public function show($docNo) {
        $viewData        = $this->getDefaultViewData();
        $viewData["aml"] = AmortizationLoan::find($docNo);

        return view('pages.amortization-loans.show', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $docNo
     * @return Response
     */
    public function edit($docNo) {
        $viewData                 = $this->getDefaultViewData();
        $viewData["aml"]          = AmortizationLoan::find($docNo);
        $viewData["openInvoices"] = SalesInvoice::OpenAndDocNo($viewData["aml"]->reference_invoice_number)->get();
        $viewData["mode"]         = "EDIT";

        return view('pages.amortization-loans.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $docNo
     * @return Response
     */
    public function update(Request $request, $docNo) {

        $aml = AmortizationLoan::find($docNo);

        if ($aml) {

            //  check if invoice number changed
            if ($request->reference_invoice_number != $aml->reference_invoice_number) {
                try {
                    //  revert back to open
                    $si         = SalesInvoice::find($aml->reference_invoice_number);
                    $si->status = "Open";
                    $si->save();
                } catch (Exception $e) {
                    return response("Failed to update invoice: {$e->getMessage()}", 500);
                }
            }

            try {
                $aml->fill($request->toArray());
            } catch (Exception $e) {
                return response($e->getMessage(), 400);
            }

            try {
                $aml->save();
            } catch (Exception $e) {
                return response($e->getMessage(), 500);
            }

            $si = SalesInvoice::find($aml->reference_invoice_number);

            if ($si) {
                $si->status = "With AML";
                $si->save();
            } else {
                throw new Exception("Sales Invoice of AML Not Found");
            }

            return $aml;
        } else {
            return response("Amortization loan document not found", 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    /**
     * @override
     */
    protected function getDefaultViewData() {
        $viewData = parent::getDefaultViewData();

        $viewData["openInvoices"] = SalesInvoice::With('reservation')->open()->get();
        
        return $viewData;
    }

}
