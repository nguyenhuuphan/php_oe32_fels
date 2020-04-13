<?php

use Illuminate\Database\Seeder;

use App\Models\Follower;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Follower::class, 100)->create();
    }
}
