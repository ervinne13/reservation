<?php

namespace App\Http\Controllers;

use App\Models\FuelType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class FuelTypesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.fuel-types.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(FuelType::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $viewData             = $this->getDefaultViewData();
        $viewData["fuelType"] = new FuelType();
        $viewData["mode"]     = "ADD";

        return view("pages.fuel-types.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $fuelType = new FuelType($request->toArray());
            $fuelType->save();
        } catch (Exception $e) {
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
        $viewData["fuelType"] = FuelType::find($id);
        $viewData["mode"]     = "VIEW";

        return view("pages.fuel-types.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData             = $this->getDefaultViewData();
        $viewData["fuelType"] = FuelType::find($id);
        $viewData["mode"]     = "EDIT";

        return view("pages.fuel-types.form", $viewData);
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
            $fuelType = FuelType::find($id);
            $fuelType->fill($request->toArray());
            $fuelType->save();
        } catch (Exception $e) {
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
            FuelType::find($id)->delete();
        } catch (Exception $e) {
            return response("Failed to delete fuel type. It may already be used in an item. Such fuel types cannot be deleted anymore for auditing purposes", 500);
        }
    }

}
