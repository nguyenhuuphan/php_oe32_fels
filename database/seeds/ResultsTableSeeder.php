<?php

use Illuminate\Database\Seeder;

use App\Models\Result;

class ResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Result::class, 30)->create();
    }
}
