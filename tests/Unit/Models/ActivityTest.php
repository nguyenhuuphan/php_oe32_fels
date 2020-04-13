<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class ActivityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $activityModel;

    protected function setUp() :void
    {
        parent::setUp();

        $this->activityModel = new Activity();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('activites', [
                'user_id',
                'activity'
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['user_id', 'activity'], $this->activityModel->getFillable());
        $this->assertEquals('activites', $this->activityModel->getTable());
    }

    public function test_a_activity_belongs_to_a_user()
    {
        $user = factory(User::class)->create(['id' => 1]);
        $activity = factory(Activity::class)->create([
            'user_id' => $user->id,
            'activity' => 'test activity content',
        ]);

        $this->assertInstanceOf(User::class, $activity->user);
        $this->assertEquals(1, $activity->user->count());
    }
}
