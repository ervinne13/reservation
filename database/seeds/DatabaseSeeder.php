<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        try {
            DB::beginTransaction();

            $this->call(PaymentTypesSeeder::class);
            $this->call(DefaultUsersSeeder::class);
            $this->call(ItemsSeeder::class);
            $this->call(NumberSeriesSeeder::class);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
