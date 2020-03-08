<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuestionRepository;

class QuestionController extends Controller
{
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
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
}
