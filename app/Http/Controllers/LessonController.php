<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CourseRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\AnswerRepository;
use App\Repositories\ResultRepository;

class LessonController extends Controller
{
    private $questionRepository;
    private $courseRepository;
    private $resultRepository;

    public function __construct(AnswerRepository $answerRepository, CourseRepository $courseRepository, QuestionRepository $questionRepository, ResultRepository $resultRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->questionRepository = $questionRepository;
        $this->resultRepository = $resultRepository;
        $this->answerRepository = $answerRepository;
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

    public function answerSingle(Request $request)
    {
        if ($request->ajax()) {
            $question_id = $request->question_id;
            $answer_id = intval($request->answer_id);
            $result = intval(($request->session()->has('result'))?($request->session()->get('result')):0);
            $right_answer = $this->answerRepository->find($answer_id);
            if ($this->answerRepository->find($answer_id)->status === 1) {
                $data = [
                    'flag'=> true,
                ];
                $result++;
            } else {
                $data = [
                    'flag'=> false,
                    'right_answer' => $this->questionRepository->find($question_id)->answers->where('status', 1)->first()->id,
                ];
            }
            $count = ($request->session()->has('questions'))?count($request->session()->get('questions')):0;
            $data['answered'] = $count+1;
            $request->session()->push('questions', $question_id);
            $request->session()->put('result', $result);
        }
        return response()->json($data, 200);
    }

    public function answerMultiple(Request $request)
    {
        if ($request->ajax()) {
            $question_id = $request->question_id;
            $answers_id = $request->answers_id;
            $result = intval(($request->session()->has('result'))?($request->session()->get('result')):0);
            $check = true;
            foreach ($answers_id as $answer_id) {
                if ($this->answerRepository->find($answer_id)->status == 0) {
                    $check = false;
                    break;
                };
            }
            if ($check) {
                $data = [
                    'flag'=> true,
                ];
                $result++;
            } else {
                $right_answers_object = $this->questionRepository->find($question_id)->answers->where('status', 1);
                $right_answers = [];
                foreach ($right_answers_object as $right_answer) {
                    array_push($right_answers, $right_answer->id);
                };
                $data = [
                    'flag'=> false,
                    'right_answers' => $right_answers,
                ];
            }
            $count = ($request->session()->has('questions'))?count($request->session()->get('questions')):0;
            $data['answered'] = $count+1;
            $request->session()->push('questions', $question_id);
            $request->session()->put('result', $result);
        }
        return response()->json($data, 200);
    }

    public function answerFillable(Request $request)
    {
        if ($request->ajax()) {
            $question_id = $request->question_id;
            $answer = $request->answer;
            $result = intval(($request->session()->has('result'))?($request->session()->get('result')):0);
            $right_answer = $this->questionRepository->find($question_id)->answers->where('status', 1)->first()->answer;
            if (strtolower($answer) === strtolower($right_answer)) {
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
            'course_id' => $course_id,
        ]);
        $request->user()->learningCourse()->sync([$course_id => ['status' => 1 ]]);
        $request->session()->forget('questions');
        $request->session()->forget('result');
        return redirect()->route('lesson.result', $course_id);
    }

    public function result(Request $request, $course_id)
    {
        $course = $this->courseRepository->find($course_id);
        $result = $request->user()->results->where('course_id', $course_id)->first()->result;
        return view('course.result', compact('course', 'result'));
    }
}
