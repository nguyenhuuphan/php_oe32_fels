<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuestionRepository;
use App\Repositories\AnswerRepository;
use App\Enums\QuestionType;

class QuestionController extends Controller
{
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $question = $this->questionRepository->create($request->all());
            $updateUrl = route('question.edit', $question->id);
            $destroyUrl = route('question.destroy', $question->id);
            $view = view('lesson.question', array('question' => $question))->render();
    
            return response()->json(['status' => true, 'question' => $question, 'updateUrl' => $updateUrl, 'destroyUrl' => $destroyUrl, 'view' => $view], 200);
        }
    }

    public function update(Request $request, $question_id)
    {
        if ($request->ajax()) {
            $this->questionRepository->update($request->all(), $question_id);
            $answers = $this->questionRepository->find($question_id)->answers;
            foreach ($answers as $answer) {
                $this->answerRepository->delete($answer->id);
            }
            $data = [
                'status' => true,
                'question_id' => $question_id,
                'question' => $request->question,
                'type' => $request->type,
                'view' => view('lesson.question', array('question' => $this->questionRepository->find($question_id)))->render(),
            ];
            
            return response()->json($data, 200);
        }
    }

    public function destroy($question_id)
    {
        $answers = $this->questionRepository->find($question_id)->answers;
        if (count($answers) > 0) {
            foreach ($answers as $answer) {
                $this->answerRepository->delete($answer->id);
            }
        }
        $this->questionRepository->delete($question_id);
        return response()->json(['status' => true, 'question_id' => $question_id], 200);
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
