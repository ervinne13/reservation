<?php

use App\Models\PaymentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("payment_types")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $entries = [
            ["code" => "PRINCIPAL", "description" => "Payment for Principal"],
            ["code" => "INTEREST", "description" => "Payment for Interest"],
            ["code" => "PENALTY", "description" => "Payment for Penalty"],
        ];

        PaymentType::insert($entries);
    }

}
