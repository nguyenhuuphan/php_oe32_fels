<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Word;
use App\Models\Course;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class WordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $wordModel;

    protected function setUp() :void
    {
        parent::setUp();

        $this->wordModel = new Word();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('words', [
                'name',
                'image',
                'spelling',
                'mean',
                'def',
                'type',
                'course_id',
                'audio',
            ]), 1);
    }

    public function test_model_configuration()
    {
        $this->assertEquals([
            'name',
            'image',
            'spelling',
            'mean',
            'def',
            'type',
            'course_id',
            'audio',
        ], $this->wordModel->getFillable());
        $this->assertEquals('words', $this->wordModel->getTable());
    }

    public function test_a_word_belongs_to_a_course()
    {
        $course = factory(Course::class)->create();
        $word = factory(Word::class)->create([
            'course_id' =>  $course->id
        ]);

        $this->assertInstanceOf(Course::class, $word->course);
        $this->assertEquals(1, $word->course->count());
    }
}
