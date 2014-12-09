<?php

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                "id"               => 1,
                "model"            => "JR125",
                "name"             => "Racal JR125",
                "cost"             => "60000",
                "reservation_cost" => "3000",
                "stock"            => 3,
                "oil_capacity"     => "0.9L",
                "engine_type"      => "1P52QMI",
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 2,
                "model"            => "MD100",
                "name"             => "Racal MD100",
                "cost"             => "40000",
                "reservation_cost" => "2000",
                "stock"            => 3,
                "oil_capacity"     => null,
                "engine_type"      => null,
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 3,
                "model"            => "MD110",
                "name"             => "Racal MD110",
                "cost"             => "50000",
                "reservation_cost" => "2500",
                "stock"            => 3,
                "oil_capacity"     => null,
                "engine_type"      => null,
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 4,
                "model"            => "Speed X125",
                "name"             => "Racal Speed X125",
                "cost"             => "60000",
                "reservation_cost" => "3000",
                "stock"            => 3,
                "oil_capacity"     => null,
                "engine_type"      => null,
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 5,
                "model"            => "TS125",
                "name"             => "Racal TS125",
                "cost"             => "60000",
                "reservation_cost" => "3000",
                "stock"            => 3,
                "oil_capacity"     => null,
                "engine_type"      => null,
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ]
        ];

        Item::insert($items);

        $itemImages = [
            [
                "item_id"     => 1,
                "description" => "Product Image",
                "url"         => "/uploads/Racal_JR125_S_1.jpg"
            ],
            [
                "item_id"     => 1,
                "description" => "Actual Image 1",
                "url"         => "/uploads/Racal_JR125_S_2.jpg"
            ],
            [
                "item_id"     => 1,
                "description" => "Actual Image 2",
                "url"         => "/uploads/Racal_JR125_S_3.jpg"
            ],
            [
                "item_id"     => 2,
                "description" => "Product Image",
                "url"         => "/uploads/Racal_MD100_S_1.jpg"
            ],
            [
                "item_id"     => 3,
                "description" => "Product Image",
                "url"         => "/uploads/Racal_JR125_S_1.jpg"
            ],
            [
                "item_id"     => 4,
                "description" => "Product Image",
                "url"         => "/uploads/Racal_Speed_X125_L_1.jpg"
            ],
            [
                "item_id"     => 5,
                "description" => "Product Image",
                "url"         => "/uploads/Racal_TS125_S_1.jpg"
            ],
        ];

        ItemImage::insert($itemImages);
    }

}
