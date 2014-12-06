<?php

use App\Models\BankAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankAccountsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("bank_accounts")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $bank_accounts = [
            [
                "account_number" => "57392837 1234567890",
                "account_name"   => "A.R.C. BPI"
            ],
            [
                "account_number" => "12345678900",
                "account_name"   => "A.R.C. BDO"
            ]
        ];

        BankAccount::insert($bank_accounts);
    }

}
