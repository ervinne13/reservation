<?php

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("items")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            [
                "model"       => "JR125",
                "name"        => "Racal JR125",
                "cost"        => "60000",
                "stock"       => 3,
                "description" => "Demo item only. DO NOT USE IN PRODUCTION!",
                "image_url"   => "/uploads/Racal_JR125_S_1.jpg"
            ],
            [
                "model"       => "MD100",
                "name"        => "Racal MD100",
                "cost"        => "40000",
                "stock"       => 3,
                "description" => "Demo item only. DO NOT USE IN PRODUCTION!",
                "image_url"   => "/uploads/Racal_MD100_S_1.jpg"
            ],
            [
                "model"       => "MD110",
                "name"        => "Racal MD110",
                "cost"        => "50000",
                "stock"       => 3,
                "description" => "Demo item only. DO NOT USE IN PRODUCTION!",
                "image_url"   => "/uploads/Racal_JR125_S_1.jpg"
            ],
            [
                "model"       => "Speed X125",
                "name"        => "Racal Speed X125",
                "cost"        => "60000",
                "stock"       => 3,
                "description" => "Demo item only. DO NOT USE IN PRODUCTION!",
                "image_url"   => "/uploads/Racal_Speed_X125_L_1.jpg"
            ],
            [
                "model"       => "TS125",
                "name"        => "Racal TS125",
                "cost"        => "60000",
                "stock"       => 3,
                "description" => "Demo item only. DO NOT USE IN PRODUCTION!",
                "image_url"   => "/uploads/Racal_TS125_S_1.jpg"
            ]
        ];

        Item::insert($items);
    }

}
