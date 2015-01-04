<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model {

    protected $fillable = [
        "model", "name", "cost", "reservation_cost", "stock", "description", "image_url"
    ];

    public static function getSummaryReports() {

        $criticalStockItemsQueryString = "SELECT COUNT(*) AS count FROM items WHERE stock < 3;";
        $outOfStockItemsQueryString    = "SELECT COUNT(*) AS count FROM items WHERE stock = 0;";
        $commitedStocksQueryString     = "SELECT COUNT(*) AS count FROM items WHERE stock < 0;";
        $withStocksQueryString         = "SELECT COUNT(*) AS count FROM items WHERE stock > 2;";

        $criticalStockItems  = DB::select(DB::raw($criticalStockItemsQueryString));
        $outOfStockItems     = DB::select(DB::raw($outOfStockItemsQueryString));
        $committedStockItems = DB::select(DB::raw($commitedStocksQueryString));
        $withStockItems      = DB::select(DB::raw($withStocksQueryString));

        $criticalStockItemCount = 0;
        $outOfStockItemCount    = 0;
        $committedStocks        = 0;
        $withStocks             = 0;

        if ($criticalStockItems && count($criticalStockItems) > 0) {
            $criticalStockItemCount = $criticalStockItems[0]->count;
        }

        if ($outOfStockItems && count($outOfStockItems) > 0) {
            $outOfStockItemCount = $outOfStockItems[0]->count;
        }

        if ($committedStockItems && count($committedStockItems) > 0) {
            $committedStocks = $committedStockItems[0]->count;
        }

        if ($withStockItems && count($withStockItems) > 0) {
            $withStocks = $withStockItems[0]->count;
        }

        return [
            "critical_items"     => $criticalStockItemCount,
            "out_of_stock_items" => $outOfStockItemCount,
            "committed_stocks"   => $committedStocks,
            "with_stocks"        => $withStocks
        ];
    }

    public function scopeStatus($query, $status) {
        switch ($status) {
            case "In Stock":
                return $query->where("stock", ">", 2);
            case "Low Stocks":
                return $query
                                ->where("stock", "<", 2)
                                ->where("stock", ">", 0);
            case "Out of Stock":
                return $query->where("stock", 0);
            case "Committed Stocks":
                return $query->where("stock", "<", 0);
            default:
                return $query;
        }
    }

    public function images() {
        return $this->hasMany(ItemImage::class);
    }

}
