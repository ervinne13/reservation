<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class ItemsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.items.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(Item::query())->make(true);
    }

    public function getAllJSON() {
        $items = Item::with('images')->get()->toArray();
        return array_map(function($item) {
            //  backwards compatibility with mobile            
            $item["image_url"] = "";

            if (count($item["images"]) > 0) {
                $item["image_url"] = $item["images"][0]["url"];
            }

            return $item;
        }, $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $viewData         = $this->getDefaultViewData();
        $viewData["item"] = new Item();
        $viewData["mode"] = "ADD";

        return view('pages.items.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $item = new Item($request->toArray());
        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }

        try {
            $item->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData         = $this->getDefaultViewData();
        $viewData["item"] = Item::find($id);
        $viewData["mode"] = "EDIT";

        return view('pages.items.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {

        $item = Item::find($id);

        if ($item) {
            try {
                $item->fill($request->toArray());
            } catch (Exception $e) {
                return response($e->getMessage(), 400);
            }

            try {
                $item->save();
            } catch (Exception $e) {
                return response($e->getMessage(), 500);
            }
        } else {
            return response("Item not found", 404);
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

}
