<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class ReservationsController extends Controller {

    protected $reseravationStatusList = [
        "Pending",
        "Rejected",
        "Validated",
//        "With S.I."   //  With S.I. Cannot be manually selected
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.reservations.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(Reservation::
                                with('item')
                                ->with('salesInvoice')
                                ->with('reservedBy')
                )->make(true);
    }

    public function convert($id) {
        try {
            $reservation  = Reservation::find($id);
            $salesInvoice = $reservation->createSI();

            return $salesInvoice;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    public function getByUserJSON($username) {
        return Reservation::ReservedByUsername($username)
                        ->with('item')
                        ->with('salesInvoice')
                        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $reservation = new Reservation($request->toArray());
            $reservation->status = "Pending";
            $reservation->save();

            return $reservation;
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
        $viewData                = $this->getDefaultViewData();
        $viewData["statusList"]  = $this->reseravationStatusList;
        $viewData["mode"]        = "view";
        $viewData["reservation"] = Reservation::find($id);

        return view('pages.reservations.show', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
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

            $reservation = Reservation::find($id);
            $reservation->fill($request->toArray());
            $reservation->save();

            return $reservation;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function updateImage(Request $request, $id) {

        $file_name   = basename($_FILES['file']['name']);
        $target_path = public_path() . "/attachments/{$file_name}";

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
            //   moving file success

            try {

                $reservation                       = Reservation::find($id);
                $reservation->attachment_image_url = "/attachments/{$file_name}";
                $reservation->save();

                return $reservation;
            } catch (Exception $e) {
                return response($e->getMessage, 500);
            }
        } else {
            return response("There was an error uploading the file, please try again!", 500);
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
            Reservation::find($id)->delete();
        } catch (\Exception $e) {
            return response("Failed to delete reservation. It may already be used in an invoice.", 500);
        }
    }

}
