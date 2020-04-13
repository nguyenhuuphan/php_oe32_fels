<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Course;
use App\Models\Question;
use App\Models\Lesson;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class LessonTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $lessonModel;
    protected $lesson;

    protected function setUp() :void
    {
        parent::setUp();

        $this->lessonModel = new Lesson();
        $this->lesson = factory(Lesson::class)->create(['id' => 1]);
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('lessons', [
                'name',
                'description',
                'course_id'
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['name', 'description', 'course_id'], $this->lessonModel->getFillable());
        $this->assertEquals('lessons', $this->lessonModel->getTable());
    }

    public function test_a_lesson_has_many_questions()
    {
        $question = factory(Question::class)->create([
            'lesson_id' => $this->lesson->id
        ]);

        $this->assertInstanceOf(Collection::class, $this->lesson->questions);
        $this->assertTrue($this->lesson->questions->contains($question));
        $this->assertEquals(1, $this->lesson->questions->count());
    }

    public function test_a_lesson_belongs_to_a_course()
    {
        $course = factory(Course::class)->create();

        $this->assertInstanceOf(Course::class, $this->lesson->course); 
    }
}
