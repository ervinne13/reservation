<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class CategoriesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.categories.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(Category::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData             = $this->getDefaultViewData();
        $viewData["category"] = new Category();
        $viewData["mode"]     = "ADD";

        return view("pages.categories.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $category = new Category($request->toArray());
            $category->save();
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
        $viewData["category"] = Category::find($id);
        $viewData["mode"]     = "VIEW";

        return view("pages.categories.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData             = $this->getDefaultViewData();
        $viewData["category"] = Category::find($id);
        $viewData["mode"]     = "EDIT";

        return view("pages.categories.form", $viewData);
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
            $category = Category::find($id);
            $category->fill($request->toArray());
            $category->save();
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
            Category::find($id)->delete();
        } catch (Exception $e) {
            return response("Failed to delete category. It may already be used in an item. Such categories cannot be deleted anymore for auditing purposes", 500);
        }
    }


}
