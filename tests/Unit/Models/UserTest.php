<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Result;
use App\Models\Course;
use App\Models\Activity;
use App\Models\Follower;
use App\Models\Word;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $userModel;
    protected $user;

    protected function setUp() :void
    {
        parent::setUp();

        $this->userModel = new User();
        $this->user = factory(User::class)->create(['id' => 1]);
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id',
                'name',
                'email',
                'email_verified_at',
                'password',
                'avatar',
                'role',
                'remember_token',
                'created_at',
                'updated_at'
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['name', 'email', 'password', 'avatar', 'role'], $this->userModel->getFillable());
        $this->assertEquals('users', $this->userModel->getTable());
        $this->assertEquals('id', $this->userModel->getKeyName());
        $this->assertEquals(['remember_token'], $this->userModel->getHidden());
    }

    public function test_a_user_has_many_results()
    {
        $course = factory(Course::class)->create(['id' => 1]);
        $result = factory(Result::class)->create([
            'user_id' => $this->user->id,
            'course_id' => $course->id
        ]);

        $this->assertInstanceOf(Collection::class, $this->user->results);
        $this->assertTrue($this->user->results->contains($result));
        $this->assertEquals(1, $this->user->results->count());
    }

    public function test_a_user_has_many_followers()
    {
        $follower = factory(Follower::class)->create([
            'user_id' => $this->user->id,
            'follower_id' => 2,
        ]);
        unset($follower['id']);

        $this->assertInstanceOf(Collection::class, $this->user->followers);
        $this->assertTrue($this->user->followers->contains($follower));
        $this->assertEquals(1, $this->user->followers->count());
    }

    public function test_a_user_has_many_activities()
    {
        $activity = factory(Activity::class)->create([
            'user_id' => $this->user->id,
            'activity' => 'test activity content',
        ]);
        unset($activity['id']);

        $this->assertInstanceOf(Collection::class, $this->user->activities);
        $this->assertTrue($this->user->activities->contains($activity));
        $this->assertEquals(1, $this->user->activities->count());
    }

    public function test_a_user_belongs_to_many_courses()
    {
        $course = factory(Course::class)->create();

        $this->assertInstanceOf(Collection::class, $this->user->courses); 
    }

    public function test_a_user_belongs_to_many_learned_words()
    {
        $course = factory(Course::class)->create();
        $word = factory(Word::class)->create([
            'course_id' => $course->id
        ]);

        $this->assertInstanceOf(Collection::class, $this->user->wordLearned); 
    }
}
