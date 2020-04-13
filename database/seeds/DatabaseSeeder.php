<?php

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
        $this->call(CoursesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LessonsTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(WordsTableSeeder::class);
        $this->call(WordLearnedTableSeeder::class);
        $this->call(FollowersTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(AnswersTableSeeder::class);
        $this->call(ResultsTableSeeder::class);
    }
}
