<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Lesson;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class AnswerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $answerModel;

    protected function setUp() :void
    {
        parent::setUp();

        $this->answerModel = new Answer();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('answers', [
                'answer',
                'question_id',
                'status'
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals(['answer', 'question_id', 'status'], $this->answerModel->getFillable());
        $this->assertEquals('answers', $this->answerModel->getTable());
    }

    public function test_a_answer_belongs_to_a_question()
    {
        $lesson = factory(Lesson::class)->create();
        $question = factory(Question::class)->create([
            'lesson_id' =>  $lesson->id
        ]);
        $answer = factory(Answer::class)->create([
            'question_id' => $question->id
        ]);

        $this->assertInstanceOf(Question::class, $answer->question);
        $this->assertEquals(1, $answer->question->count());
    }
}
