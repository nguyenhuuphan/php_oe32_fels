<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Course;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class ResultTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $resultModel;

    protected function setUp() :void
    {
        parent::setUp();

        $this->resultModel = new Result();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('results', [
                'result',
                'course_id',
                'user_id'
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['result', 'course_id', 'user_id'], $this->resultModel->getFillable());
        $this->assertEquals('results', $this->resultModel->getTable());
    }

    public function test_a_result_belongs_to_a_user()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $result = factory(Result::class)->create([
            'course_id' =>  $course->id,
            'user_id' =>  $user->id
        ]);

        $this->assertInstanceOf(User::class, $result->user);
        $this->assertEquals(1, $result->user->count());
    }

    public function test_a_result_belongs_to_a_course()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $result = factory(Result::class)->create([
            'course_id' =>  $course->id,
            'user_id' =>  $user->id
        ]);

        $this->assertInstanceOf(Course::class, $result->course);
        $this->assertEquals(1, $result->course->count());
    }
}
