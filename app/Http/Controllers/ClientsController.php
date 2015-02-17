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

    public function activate($clientId) {
        try {
            $client            = Client::find($clientId);
            $client->is_active = 1;
            $client->save();

            $clientUser = $client->user;
            if ($clientUser) {
                $clientUser->is_active = 1;
                $clientUser->save();
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function deactivate($clientId) {
        try {
            $client            = Client::find($clientId);
            $client->is_active = 0;
            $client->save();

            $clientUser = $client->user;
            if ($clientUser) {
                $clientUser->is_active = 0;
                $clientUser->save();
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
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
     */
    public function store(Request $request) {

        try {

            DB::beginTransaction();

            $user               = new User();
            $user->username     = $request->username;
            $user->display_name = $request->full_name;
            $user->role_name    = User::ROLE_CLIENT;
            $user->password     = \Hash::make($request->password);
            $user->generateAPIToken();
            $user->save();

            $client = new Client($request->toArray());
            $client->save();

            DB::commit();

            $user->client = $client;

            return $user;
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

        try {

            DB::beginTransaction();

            $user               = User::find($id);
            $user->username     = $request->username;
            $user->display_name = $request->full_name;
            $user->role_name    = User::ROLE_CLIENT;
            $user->password     = \Hash::make($request->password);
            $user->generateAPIToken();
            $user->save();

            $client = Client::find($id);
            $client->fill($request->toArray());
            $client->save();

            DB::commit();

            $user->client = $client;

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $iResponseate\Http\Response
     */
    public function destroy($id) {
        try {
            Client::find($id)->delete();
        } catch (\Exception $e) {
            return response("Failed to delete client. It may already be used in other transactions. You may only delete clients that does not have any transaciton yet.", 500);
        }
    }

}
