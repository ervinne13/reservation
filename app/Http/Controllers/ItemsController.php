<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FuelType;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class ItemsController extends Controller {

    protected $itemCategories = ["Scooter", "Kick Start", "Underbone", "Backbone"];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData           = $this->getDefaultViewData();
        $viewData["status"] = NULL;
        return view('pages.items.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(Item::query())->make(true);
    }

    public function viewlistByStatus($status) {
        $viewData           = $this->getDefaultViewData();
        $viewData["status"] = $status;
        return view('pages.items.index', $viewData);
    }

    public function datatableByStatus($status) {
        return Datatables::of(Item::Status($status))->make(true);
    }

    public function getAllJSON() {
        $items = Item::with('images')
                ->with('supplier')
                ->with('fuelType')
                ->get()
                ->toArray();

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

        $viewData               = $this->getDefaultFormViewData();        
        $viewData["item"]       = new Item();
        $viewData["mode"]       = "ADD";

        return view('pages.items.form', $viewData);
    }

    public function itemFiles($itemId) {
        $itemImages = ItemImage::where("item_id", $itemId)->get();
        $files      = [];

        foreach ($itemImages AS $image) {
            array_push($files, [
                "name" => $image->url,
                "size" => File::size(public_path() . $image->url)
            ]);
        }

        return $files;
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

            if ($request->images) {

                ItemImage::where("item_id", $item->id)->delete();

                $imageUploads = [];

                foreach ($request->images AS $image) {
                    array_push($imageUploads, [
                        "item_id" => $item->id,
                        "url"     => "/uploads/{$image["server_filename"]}",
                    ]);
                }

                ItemImage::insert($imageUploads);
            }
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
        $viewData               = $this->getDefaultFormViewData();        
        $viewData["item"]       = Item::find($id);
        $viewData["mode"]       = "EDIT";

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

                if ($request->images) {

                    ItemImage::where("item_id", $item->id)->delete();

                    $imageUploads = [];
                    echo json_encode($request->images);
                    foreach ($request->images AS $image) {

                        if ($image) {
                            array_push($imageUploads, [
                                "item_id" => $item->id,
                                "url"     => "/uploads/{$image["server_filename"]}",
                            ]);
                        }
                    }

                    ItemImage::insert($imageUploads);
                }
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
        try {
            Item::find($id)->delete();
        } catch (\Exception $e) {
            return response("Failed to delete item. It may already be used in an invoice. Such items cannot be deleted anymore for auditing purposes", 500);
        }
    }

    protected function getDefaultFormViewData() {
        $viewData = $this->getDefaultViewData();

        $viewData["categories"] = Category::all();
        $viewData["fuelTypes"]  = FuelType::all();
        $viewData["suppliers"]  = Supplier::all();

        return $viewData;
    }

}
