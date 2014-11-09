<?php

use App\Models\NumberSeries;
use Illuminate\Database\Seeder;

class NumberSeriesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("number_series")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $numberSeries = [
            [
                "code"             => "SI",
                "starting_number"  => 100000,
                "last_number_used" => 100000,
                "finalized"        => 0
            ],
            [
                "code"             => "AML",
                "starting_number"  => 100000,
                "last_number_used" => 100000,
                "finalized"        => 0
            ],
            [
                "code"             => "RP",
                "starting_number"  => 100000,
                "last_number_used" => 100000,
                "finalized"        => 0
            ]
        ];

        NumberSeries::insert($numberSeries);
    }

}
