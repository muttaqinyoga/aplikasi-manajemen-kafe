<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Table;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
        	'name' => 'Owner',
        	'email' => 'admin@kafe.com',
        	'password' => bcrypt('Admin246'),
        	'role' => 62
        ]);
        // Table
        for($i=1; $i<=20; $i++)
        {
            Table::create([
                'table_number' => $i
            ]);
        }
    }
}
