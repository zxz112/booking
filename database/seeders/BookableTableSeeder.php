<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bookable;

class BookableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::factory()
            ->count(150)
            ->create();
    }
}
