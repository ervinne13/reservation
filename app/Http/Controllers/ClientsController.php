<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class ClientsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.clients.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(Client::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
      Responseate\Http\Response
     */
    public function create() {
        $viewData           = $this->getDefaultViewData();
        $viewData["client"] = new Client();
        $viewData["mode"]   = "ADD";

        return view('pages.clients.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
      Requestnate\Http\Request  $requesResponseate\Http\Response
     */
    public function store(Request $request) {

        try {

            DB::beginTransaction();

            $user               = new User();
            $user->username     = $request->username;
            $user->display_name = $request->full_name;
            $user->role_name    = User::ROLE_CLIENT;
            $user->password     = \Hash::make($request->password);
            $user->save();

            $client = new Client($request->toArray());
            $client->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $iResponseate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $iResponseate\Http\Response
     */
    public function edit($id) {
        $viewData           = $this->getDefaultViewData();
        $viewData["client"] = Client::find($id);
        $viewData["mode"]   = "EDIT";

        return view('pages.clients.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
      Requestnate\Http\Request  $request
     * @param  int  $iResponseate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $iResponseate\Http\Response
     */
    public function destroy($id) {
        //
    }

}