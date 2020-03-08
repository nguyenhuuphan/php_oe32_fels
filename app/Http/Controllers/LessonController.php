<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CourseRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ResultRepository;

class LessonController extends Controller
{
    private $questionRepository;
    private $courseRepository;
    private $resultRepository;

    public function __construct(CourseRepository $courseRepository, QuestionRepository $questionRepository, ResultRepository $resultRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->questionRepository = $questionRepository;
        $this->resultRepository = $resultRepository;
    }

    public function answer(Request $request)
    {
        if ($request->ajax()) {
            $question_id = $request->question_id;
            $answer_id = intval($request->answer_id);
            $result = intval(($request->session()->has('result'))?($request->session()->get('result')):0);
            $right_answer = $this->questionRepository->find($question_id)->answer_id;
            if ($answer_id === $right_answer) {
                $data = [
                    'flag'=> true,
                ];
                $result++;
            } else {
                $data = [
                    'flag'=> false,
                    'right_answer' => $right_answer,
                ];
            }
            $count = ($request->session()->has('questions'))?count($request->session()->get('questions')):0;
            $data['answered'] = $count+1;
            $request->session()->push('questions', $question_id);
            $request->session()->put('result', $result);
        }
        return response()->json($data, 200);
    }
    
    public function endLesson(Request $request, $course_id)
    {
        $lesson = $this->courseRepository->find($course_id)->lesson()->first();
        $questions = count($lesson->questions()->get());
        $result = ($request->session()->get('result') / $questions)*10;
        $this->resultRepository->create([
            'user_id' => $request->user()->id,
            'result' => $result,
            'lesson_id' => $lesson->id,
        ]);
        return redirect()->route('lesson.result', $course_id);
    }

    public function result(Request $request, $course_id)
    {
        $course = $this->courseRepository->find($course_id);
        $result = $request->user()->result()->first()->result;
        return view('course.result', compact('course', 'result'));
    }
}
