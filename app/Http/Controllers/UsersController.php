<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.users.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(User::query())->make(true);
    }

    public function apiLogin(Request $request) {
        if (Auth::attempt($request->toArray())) {
            // Authentication passed...
            return Auth::user();
        } else {
            return response("Invalid login credentials", 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData          = $this->getDefaultViewData();
        $viewData["user"]  = new User();
        $viewData ["mode"] = "ADD";

        return view('pages.users.form', $viewData);
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

            $user           = new User($request->toArray());
            $user->password = \Hash::make($request->password);
            $user->save();

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData          = $this->getDefaultViewData();
        $viewData["user"]  = User::find($id);
        $viewData ["mode"] = "EDIT";

        return view('pages.users.form', $viewData);
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
            $user = User::find($id);

            if (!$user) {
                return response("User not found", 404);
            }

            $user->fill($request->toArray());

            if ($request->password) {
                $user->password = \Hash::make($request->password);
            }

            $user->save();
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
        //
    }

    /**
     * @override
     */
    protected function getDefaultViewData() {
        $viewData = parent::getDefaultViewData();

        $viewData["roles"] = [
            "ADMIN", "SECRETARY", "ACCOUNTANT"
        ];

        return $viewData;
    }

}
