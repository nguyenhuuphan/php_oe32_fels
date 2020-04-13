<?php

use Illuminate\Database\Seeder;

use App\Models\Answer;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Answer::class, 100)->create();
    }
}
