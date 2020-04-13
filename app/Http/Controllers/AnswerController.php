<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use App\Enums\QuestionType;

class AnswerController extends Controller
{
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepository, QuestionRepository $questionRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->questionRepository = $questionRepository;
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $answer = $this->answerRepository->create($request->all());;
            $question = $this->questionRepository->find($request->question_id);
            $updateUrl = route('answer.edit', $answer->id);
            $destroyUrl = route('answer.destroy', $answer->id);
            $view = view('lesson.question', array('question' => $question))->render();
    
            return response()->json(['status' => true, 'question' => $question, 'updateUrl' => $updateUrl, 'destroyUrl' => $destroyUrl, 'view' => $view], 200);
        }
    }

    public function update(Request $request, $answer_id)
    {
        $this->answerRepository->update(['answer' => $request->answer], $answer_id);
        return response()->json(['status' => true], 200);
    }

    public function destroy($answer_id)
    {
        $this->answerRepository->delete($answer_id);
        return response()->json(['status' => true, 'answer_id' => $answer_id], 200);
    }

    public function rightAnswer(Request $request)
    {
        $question = $this->questionRepository->find($request->question_id);
        $answer = $this->answerRepository->find($request->answer_id);

        switch ($question->type) {
            case QuestionType::Single:
                if (count($question->answers->where('status', 1))) {
                    $old_answer = $question->answers->where('status', 1)->first();
                    $this->answerRepository->update(['status' => 0], $old_answer->id);
                }
                $this->answerRepository->update(['status' => 1], $request->answer_id);
                break;

            case QuestionType::Multiple:
                if ($request->prop == 'true') {
                    $this->answerRepository->update(['status' => 1], $request->answer_id);
                } else {
                    $this->answerRepository->update(['status' => 0], $request->answer_id);
                }
                break;
        }

        $question = $this->questionRepository->find($request->question_id);
        $view = view('lesson.question', array('question' => $question))->render();

        return response()->json(['status' => true, 'view' => $view], 200);
    }
}
