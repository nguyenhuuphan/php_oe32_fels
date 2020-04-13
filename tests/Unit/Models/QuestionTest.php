<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class QuestionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $questionModel;

    protected function setUp() :void
    {
        parent::setUp();

        $this->questionModel = new Question();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('questions', [
                'question',
                'lesson_id',
                'type'
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['question', 'lesson_id', 'type'], $this->questionModel->getFillable());
        $this->assertEquals('questions', $this->questionModel->getTable());
    }

    public function test_a_question_has_many_answers()
    {
        $lesson = factory(Lesson::class)->create();
        $question = factory(Question::class)->create([
            'lesson_id' =>  $lesson->id
        ]);
        $answer = factory(Answer::class)->create([
            'question_id' => $question->id
        ]);

        $this->assertInstanceOf(Collection::class, $question->answers);
        $this->assertTrue($question->answers->contains($answer));
        $this->assertEquals(1, $question->answers->count());
    }

    public function test_a_question_belongs_to_a_lesson()
    {
        $lesson = factory(Lesson::class)->create();
        $question = factory(Question::class)->create([
            'lesson_id' =>  $lesson->id
        ]);

        $this->assertInstanceOf(Lesson::class, $question->lesson);
        $this->assertEquals(1, $question->lesson->count());
    }
}
