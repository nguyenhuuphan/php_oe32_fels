<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Course;
use App\Models\Word;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class CourseTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $courseModel;
    protected $course;

    protected function setUp() :void
    {
        parent::setUp();

        $this->courseModel = new Course();
        $this->course = factory(Course::class)->create(['id' => 1]);
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('courses', [
                'name',
                'description',
                'image'
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['name', 'description', 'image'], $this->courseModel->getFillable());
        $this->assertEquals('courses', $this->courseModel->getTable());
    }

    public function test_a_course_has_many_words()
    {
        $word = factory(Word::class)->create([
            'course_id' => $this->course->id
        ]);

        $this->assertInstanceOf(Collection::class, $this->course->words);
        $this->assertTrue($this->course->words->contains($word));
        $this->assertEquals(1, $this->course->words->count());
    }

    public function test_a_course_has_a_lesson()
    {
        $lesson = factory(Lesson::class)->create([
            'course_id' => $this->course->id
        ]);

        $this->assertInstanceOf(Lesson::class, $this->course->lesson);
        $this->assertEquals(1, $this->course->lesson->count());
    }

    public function test_a_course_belongs_to_many_users()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $this->course->users); 
    }
}
