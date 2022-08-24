<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CommonStatusesSeeder::class);
        $this->call(ProductStatusesSeeder::class);
        $this->call(ModelNamesSeeder::class);
    }
}
