<?php

use App\Models\FuelType;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Supplier;
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
        DB::table("categories")->truncate();
        DB::table("fuel_types")->truncate();
        DB::table("suppliers")->truncate();
        DB::table("items")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            ["id" => 1, "name" => "Scooter"],
            ["id" => 2, "name" => "Kick Start"],
            ["id" => 3, "name" => "Underbone"],
            ["id" => 4, "name" => "Backbone"]
        ];

        App\Models\Category::insert($categories);

        $suppliers = [
            ["id" => 1, "name" => "Yamaha"],
            ["id" => 2, "name" => "Suzuki"],
            ["id" => 3, "name" => "Honda"],
            ["id" => 4, "name" => "Rusi"],
            ["id" => 5, "name" => "Racal"],
            ["id" => 6, "name" => "Motorstar"],
            ["id" => 7, "name" => "Kawasaki"]
        ];

        Supplier::insert($suppliers);

        $fuelTypes = [
            ["id" => 1, "name" => "Unleaded"],
            ["id" => 2, "name" => "Gasoline"],
            ["id" => 3, "name" => "LPG"],
            ["id" => 4, "name" => "Diesel"],
        ];

        FuelType::insert($fuelTypes);

        $items = [
            [
                "id"               => 1,
                "category_id"      => 1,
                "model"            => "JR125",
                "name"             => "Racal JR125",
                "cost"             => "60000",
                "reservation_cost" => "3000",
                "supplier_id"      => 5,
                "fuel_type_id"     => 4,
                "stock"            => 3,
                "oil_capacity"     => "0.9L",
                "engine_type"      => "1P52QMI",
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 2,
                "category_id"      => 2,
                "model"            => "MD100",
                "name"             => "Racal MD100",
                "cost"             => "40000",
                "reservation_cost" => "2000",
                "supplier_id"      => 5,
                "fuel_type_id"     => 4,
                "stock"            => 3,
                "oil_capacity"     => null,
                "engine_type"      => null,
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 3,
                "category_id"      => 2,
                "model"            => "MD110",
                "name"             => "Racal MD110",
                "cost"             => "50000",
                "reservation_cost" => "2500",
                "supplier_id"      => 5,
                "fuel_type_id"     => 4,
                "stock"            => 3,
                "oil_capacity"     => null,
                "engine_type"      => null,
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 4,
                "category_id"      => 2,
                "model"            => "Speed X125",
                "name"             => "Racal Speed X125",
                "cost"             => "60000",
                "reservation_cost" => "3000",
                "supplier_id"      => 5,
                "fuel_type_id"     => 4,
                "stock"            => 3,
                "oil_capacity"     => null,
                "engine_type"      => null,
                "description"      => "Demo item only. DO NOT USE IN PRODUCTION!"
            ],
            [
                "id"               => 5,
                "category_id"      => 2,
                "model"            => "TS125",
                "name"             => "Racal TS125",
                "cost"             => "60000",
                "reservation_cost" => "3000",
                "supplier_id"      => 5,
                "fuel_type_id"     => 4,
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
