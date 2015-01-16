<?php

namespace App\Http\Controllers;

use App\Models\AmortizationLoan;
use App\Models\AmortizationLoanDetail;
use App\Models\Client;
use App\Models\PaymentType;
use App\Models\RequestPayment;
use App\Models\RequestPaymentDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;

class RequestPaymentsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.request-payments.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(RequestPayment::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData         = $this->getDefaultViewData();
        $viewData["rp"]   = RequestPayment::make();
        $viewData["mode"] = "ADD";

        $viewData["amortizationDocumentList"] = AmortizationLoan::Open()->get();

        return view('pages.request-payments.form', $viewData);
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

            //  header
            $rpHeader = new RequestPayment($request->toArray());
            $rpHeader->save();

            $details = json_decode($request->details, true);

            $principalPayment = 0;

            foreach ($details AS $rpDetail) {
                $rpDetail["document_number"] = $rpHeader->document_number;
                $rpDetail                    = new RequestPaymentDetail($rpDetail);
                $rpDetail->save();

                if ($rpDetail->payment_type_code == "PRINCIPAL") {
                    $principalPayment += $rpDetail->amount;
                }
            }

//            $aml = AmortizationLoan::find($rpHeader->applies_to);
//            $aml->remaining_amount -=$principalPayment;
//
//            if ($aml->remaining_amount > 0) {
//                $aml->status = "Partially Paid";
//            } else {
//                $aml->status = "Fully Paid";
//            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $viewData                   = $this->getDefaultViewData();
        $viewData["requestPayment"] = RequestPayment::find($id);

        return view('pages.request-payments.show', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $docNo
     * @return Response
     */
    public function edit($docNo) {
        $viewData         = $this->getDefaultViewData();
        $viewData["rp"]   = RequestPayment::find($docNo);
        $viewData["mode"] = "EDIT";

        $viewData["amortizationDocumentList"] = AmortizationLoan::OpenAndDocNo($viewData["rp"]->applies_to)->get();

        return view('pages.request-payments.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $docNo
     * @return Response
     */
    public function update(Request $request, $docNo) {
        
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

    public function postAndSave(Request $request) {
        try {

            DB::beginTransaction();

            //  header
            $rpHeader         = new RequestPayment($request->toArray());
            $rpHeader->status = "Posted";
            $rpHeader->save();

            $details = json_decode($request->details, true);

            $principalPayment = 0;
            $interestPayment  = 0;
            $penaltyPayment   = 0;

            foreach ($details AS $rpDetail) {

                $rpDetail["document_number"] = $rpHeader->document_number;
                $rpDetail                    = new RequestPaymentDetail($rpDetail);
                $rpDetail->save();

                switch ($rpDetail["payment_type_code"]) {
                    case "PRINCIPAL":
                        $principalPayment += $rpDetail["amount"];
                        break;
                    case "INTEREST":
                        $interestPayment  += $rpDetail["amount"];
                        break;
                    case "PENALTY":
                        $penaltyPayment   += $rpDetail["amount"];
                        break;
                }
            }

            $aml                   = AmortizationLoan::find($rpHeader->applies_to);
            $aml->remaining_amount = $aml->remaining_amount - $principalPayment;

            echo "{$aml->remaining_amount} {$principalPayment}";

            if ($aml->remaining_amount > 0) {
                $aml->status = "Partially Paid";
            } else {
                $aml->status = "Fully Paid";
            }

            $aml->save();

            $amlDetail                          = new AmortizationLoanDetail();
            $amlDetail->document_number         = $aml->document_number;
            $amlDetail->payment_date            = $rpHeader->document_date;
            $amlDetail->payment_document_number = $rpHeader->document_number;
            $amlDetail->payment_amount          = $rpHeader->total_payment;
            $amlDetail->principal_payment       = $principalPayment;
            $amlDetail->interest_payment        = $interestPayment;
            $amlDetail->penalty_payment         = $penaltyPayment;
            $amlDetail->running_balance         = $aml->remaining_amount;

            $amlDetail->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response($e->getMessage(), 500);
        }
    }

    public function post($docNo) {

        try {

            DB::beginTransaction();

            $rp         = RequestPayment::find($docNo);
            $rp->status = "Posted";
            $rp->save();

            $details = $rp->details;

            $principalPayment = 0;
            $interestPayment  = 0;
            $penaltyPayment   = 0;

            foreach ($details AS $rpDetail) {

                switch ($rpDetail->payment_type_code) {
                    case "PRINCIPAL":
                        $principalPayment += $rpDetail->amount;
                        break;
                    case "INTEREST":
                        $interestPayment  += $rpDetail->amount;
                        break;
                    case "PENALTY":
                        $penaltyPayment   += $rpDetail->amount;
                        break;
                }
            }

            $aml                   = AmortizationLoan::find($rp->applies_to);
            $aml->remaining_amount = $aml->remaining_amount - $principalPayment;

            if ($aml->remaining_amount > 0) {
                $aml->status = "Partially Paid";
            } else {
                $aml->status = "Fully Paid";
            }

            $amlDetail                          = new AmortizationLoanDetail();
            $amlDetail->document_number         = $aml->document_number;
            $amlDetail->payment_document_number = $rp->document_number;
            $amlDetail->payment_amount          = $rp->total_payment;
            $amlDetail->principal_payment       = $principalPayment;
            $amlDetail->interest_payment        = $interestPayment;
            $amlDetail->penalty_payment         = $penaltyPayment;
            $amlDetail->running_balance         = $aml->remaining_amount;

            $aml->save();
            $amlDetail->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    protected function getDefaultViewData() {
        $viewData                 = parent::getDefaultViewData();
        $viewData["clients"]      = Client::all();
        $viewData["paymentTypes"] = PaymentType::all();

        return $viewData;
    }

}
