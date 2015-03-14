<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesInvoice extends Model {

    protected $primaryKey = "document_number";
    public $incrementing  = false;
    protected $fillable   = [
        "document_number", "document_date", "total_amount", "down_payment", "issued_by_username", "issued_to_username", "issued_to_name", "issued_to_address", "remarks"
    ];

    public static function make() {
        $si                     = new SalesInvoice();
        $si->document_number    = NumberSeries::get("SI");
        $si->document_date      = date('Y-m-d');
        $si->status             = "Open";
        $si->issued_by_username = Auth::user()->username;
        $si->details            = [];
        return $si;
    }

    public static function getDailySales() {
        $queryString = 'SELECT document_date, SUM(down_payment) AS total_sales 
                        FROM reservation.sales_invoices                        
                        GROUP BY document_date
                        ORDER BY document_date DESC
                        LIMIT 0, 30;';

        return DB::select(DB::raw($queryString));
    }

    public static function getMonthlySales() {
        $queryString = 'SELECT YEAR(document_date) AS sales_year, MONTH(document_date) AS sales_month, SUM(down_payment) AS total_sales 
                        FROM reservation.sales_invoices
                        GROUP BY sales_year, sales_month
                        ORDER BY sales_year DESC, sales_month DESC;';

        return DB::select(DB::raw($queryString));
    }

    public static function getMonthlyCollections() {
        $queryString = 'SELECT 
                                YEAR(request_payments.document_date) AS collection_year,
                            MONTH(request_payments.document_date) AS collection_month,
                                SUM(amount) AS total_collections 
                        FROM reservation.request_payment_details 
                        LEFT JOIN reservation.request_payments 
                                ON request_payments.document_number = request_payment_details.document_number 

                        WHERE status = \'Posted\' AND payment_type_code=\'PRINCIPAL\'
                        GROUP BY collection_year, collection_month
                        ORDER BY collection_year DESC, collection_month DESC';
        return DB::select(DB::raw($queryString));
    }

    public static function getSummaryReports() {

        $currentYear  = date('Y');
        $currentMonth = date('m');

        $totalSalesOfTheYearQueryString        = "SELECT SUM(down_payment) AS total_sales FROM sales_invoices WHERE YEAR(created_at) = {$currentYear};";
        $totalSalesOfTheMonthQueryString       = "SELECT SUM(down_payment) AS total_sales FROM sales_invoices WHERE YEAR(created_at) = {$currentYear} AND MONTH(created_at) = {$currentMonth};";
        $totalCollectionsOfTheMonthQueryString = "SELECT SUM(amount) AS total_collections FROM request_payment_details LEFT JOIN request_payments ON request_payments.document_number = request_payment_details.document_number WHERE YEAR(request_payments.created_at) = {$currentYear} AND MONTH(request_payments.created_at) = {$currentMonth} AND status = 'Posted' AND payment_type_code='PRINCIPAL';";

        $totalSalesOfTheYearRow        = DB::select(DB::raw($totalSalesOfTheYearQueryString));
        $totalSalesOfTheMonthRow       = DB::select(DB::raw($totalSalesOfTheMonthQueryString));
        $totalCollectionsOfTheMonthRow = DB::select(DB::raw($totalCollectionsOfTheMonthQueryString));

        $totalSales       = 0;
        $monthSales       = 0;
        $totalCollections = 0;

        if ($totalSalesOfTheYearRow && count($totalSalesOfTheYearRow) > 0) {
            $totalSales = $totalSalesOfTheYearRow[0]->total_sales;
        }

        if ($totalSalesOfTheMonthRow && count($totalSalesOfTheMonthRow) > 0) {
            $monthSales = $totalSalesOfTheMonthRow[0]->total_sales;
        }

        if ($totalCollectionsOfTheMonthRow && count($totalCollectionsOfTheMonthRow) > 0) {
            $totalCollections = $totalCollectionsOfTheMonthRow[0]->total_collections;
        }

        return [
            "total_sales"       => $totalSales,
            "month_sales"       => $monthSales,
            "total_collections" => $totalCollections
        ];
    }

    function details() {
        return $this->hasMany(SalesInvoiceDetail::class, 'document_number', 'document_number');
    }

    function issuedTo() {
        return $this->belongsTo(Client::class, 'issued_to_username');
    }

    function issuedBy() {
        return $this->belongsTo(User::class, 'issued_by_username');
    }

    function reservation() {
        return $this->hasOne(Reservation::class, 'sales_invoice_no');
    }

    function scopeOpen($query) {
        return $query->where('status', 'Open');
    }

    function scopeOpenAndDocNo($query, $siDocNo) {
        return $query->where('status', 'Open')->orWhere('document_number', $siDocNo);
    }

}
