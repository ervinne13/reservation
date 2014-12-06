<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Item;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class SalesInvoicesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.sales-invoices.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(SalesInvoice::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData                 = $this->getDefaultViewData();
        $viewData["salesInvoice"] = SalesInvoice::make();
        $viewData["mode"]         = "ADD";

        return view('pages.sales-invoices.form', $viewData);
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
            $siHeader = new SalesInvoice($request->toArray());

            if ($siHeader->total_amount > $siHeader->down_payment) {
                $siHeader->status = "Open";
            } else {
                $siHeader->status = "Fully Payed";
            }

            $siHeader->save();

            $details = json_decode($request->details, true);

            foreach ($details AS $siDetailAssoc) {
                $siDetailAssoc["document_number"] = $siHeader->document_number;
                $siDetail                         = new SalesInvoiceDetail($siDetailAssoc);
                $siDetail->save();

                //  update stocks
                $item = Item::find($siDetail->item_id);
                $item->stock-= $siDetail->item_qty;
                $item->save();
            }

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
        $viewData                 = $this->getDefaultViewData();
        $viewData["salesInvoice"] = SalesInvoice::find($id);

        return view('pages.sales-invoices.show', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData                 = $this->getDefaultViewData();
        $viewData["salesInvoice"] = SalesInvoice::find($id);
        $viewData["mode"]         = "EDIT";

        return view('pages.sales-invoices.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $docNo
     * @return Response
     */
    public function update(Request $request, $docNo) {

        try {
            DB::beginTransaction();

            //  header
            $siHeader = SalesInvoice::find($docNo);
            $siHeader->fill($request->toArray());

            if ($siHeader->total_amount > $siHeader->down_payment) {
                $siHeader->status = "Open";
            } else {
                $siHeader->status = "Fully Payed";
            }

            $siHeader->save();

            $details = json_decode($request->details, true);

            foreach ($details AS $siDetailAssoc) {
                $siDetailAssoc["document_number"] = $siHeader->document_number;

                $siDetail = SalesInvoiceDetail::findOrNew($siDetailAssoc["line_number"]);
                $siDetail->fill($siDetailAssoc);
                $siDetail->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
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

    public function destroyDetail($id) {

        try {

            DB::beginTransaction();

            $siDetail = SalesInvoiceDetail::find($id);

            if ($siDetail) {

                $siHeader               = SalesInvoice::find($siDetail->document_number);
                $siHeader->total_amount = $siHeader->total_amount - $siDetail->sub_total;
                $siHeader->save();

                $siDetail->delete();
            } else {
                return response("Detail not found", 404);
            }

            DB::commit();
            return "OK";
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * @override
     */
    protected function getDefaultViewData() {
        $viewData = parent::getDefaultViewData();

        $viewData["clients"] = Client::all();
        $viewData["items"]   = Item::all();

        return $viewData;
    }

}
