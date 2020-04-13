<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class FollowerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $followerModel;
    protected $user;

    protected function setUp() :void
    {
        parent::setUp();

        $this->followerModel = new Follower();
        $this->user = factory(User::class)->create(['id' => 1]);
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('followers', [
                'user_id',
                'follower_id',
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['user_id', 'follower_id'], $this->followerModel->getFillable());
        $this->assertEquals('followers', $this->followerModel->getTable());
    }

    public function test_a_follower_belongs_to_a_user()
    {
        $follower = factory(Follower::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->assertInstanceOf(User::class, $follower->user);
        $this->assertEquals(1, $follower->user->count());
    }
}
