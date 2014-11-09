<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultUsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //  reset
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //  RP
        DB::table("request_payment_details")->truncate();
        DB::table("request_payments")->truncate();

        //  AML
        DB::table("amortization_loan_details")->truncate();
        DB::table("amortization_loans")->truncate();

        //  SI
        DB::table("sales_invoice_details")->truncate();
        DB::table("sales_invoices")->truncate();

        //  Users
        DB::table("clients")->truncate();
        DB::table("users")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //  Create users
        $users = [
            ["username" => "admin", "is_active" => 1, "role_name" => "ADMIN", "display_name" => "Administrator", "password" => \Hash::make("password")],
            ["username" => "secretary1", "is_active" => 1, "role_name" => "SECRETARY", "display_name" => "Secretary 1", "password" => \Hash::make("password")],
            ["username" => "secretary2", "is_active" => 1, "role_name" => "SECRETARY", "display_name" => "Secretary 2", "password" => \Hash::make("password")],
        ];

        User::insert($users);

        //  create sample clients
        $clientUsers = [
            ["username" => "juandc", "is_active" => 1, "role_name" => "CLIENT", "display_name" => "Juan Dela Cruz", "password" => \Hash::make("password")],
        ];
        $clients     = [
            ["username" => "juandc", "is_active" => 1, "is_delinquent" => 0, "full_name" => "Juan Dela Cruz", "contact_number_1" => "091234567", "landline_number" => "123-1234", "address" => "sample address only"],
        ];

        User::insert($clientUsers);
        Client::insert($clients);
    }

}
