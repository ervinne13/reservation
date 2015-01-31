<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class SuppliersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.suppliers.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(Supplier::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $viewData             = $this->getDefaultViewData();
        $viewData["supplier"] = new Supplier();
        $viewData["mode"]     = "ADD";

        return view("pages.suppliers.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $supplier = new Supplier($request->toArray());
            $supplier->save();
        } catch (\Exception $e) {
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
        $viewData             = $this->getDefaultViewData();
        $viewData["supplier"] = Supplier::find($id);
        $viewData["mode"]     = "VIEW";

        return view("pages.suppliers.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData             = $this->getDefaultViewData();
        $viewData["supplier"] = Supplier::find($id);
        $viewData["mode"]     = "EDIT";

        return view("pages.suppliers.form", $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $supplier = Supplier::find($id);
            $supplier->fill($request->toArray());
            $supplier->save();
        } catch (\Exception $e) {
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
        try {
            Supplier::find($id)->delete();
        } catch (Exception $e) {
            return response("Failed to delete supplier. It may already be used in an item. Such suppliers cannot be deleted anymore for auditing purposes", 500);
        }
    }

}
