<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model {

    protected $fillable = [
        "model", "name", "cost", "stock", "description", "image_url"
    ];

    public static function getSummaryReports() {

        $criticalStockItemsQueryString = "SELECT COUNT(*) AS count FROM items WHERE stock < 3;";
        $outOfStockItemsQueryString    = "SELECT COUNT(*) AS count FROM items WHERE stock = 0;";
        $commitedStocksQueryString     = "SELECT COUNT(*) AS count FROM items WHERE stock < 0;";

        $criticalStockItems  = DB::select(DB::raw($criticalStockItemsQueryString));
        $outOfStockItems     = DB::select(DB::raw($outOfStockItemsQueryString));
        $committedStockItems = DB::select(DB::raw($commitedStocksQueryString));

        $criticalStockItemCount = 0;
        $outOfStockItemCount    = 0;
        $committedStocks        = 0;

        if ($criticalStockItems && count($criticalStockItems) > 0) {
            $criticalStockItemCount = $criticalStockItems[0]->count;
        }

        if ($outOfStockItems && count($outOfStockItems) > 0) {
            $outOfStockItemCount = $outOfStockItems[0]->count;
        }

        if ($committedStockItems && count($committedStockItems) > 0) {
            $committedStocks = $committedStockItems[0]->count;
        }

        return [
            "critical_items"     => $criticalStockItemCount,
            "out_of_stock_items" => $outOfStockItemCount,
            "committed_stocks"   => $committedStocks,
        ];
    }

}
