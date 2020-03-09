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

    public function store(Request $request)
    {
        $this->questionRepository->create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $question_id)
    {
        $this->questionRepository->update(['question' => $request->question], $question_id);
        return response()->json(['status' => true], 200);
    }

    public function destroy($question_id)
    {
        $this->questionRepository->delete($question_id);
        return response()->json(['status' => true, 'question_id' => $question_id], 200);
    }

    public function rightAnswer(Request $request)
    {
        $question_id = $request->question_id;
        $answer_id = $request->answer_id;
        $this->questionRepository->update(['answer_id' => $answer_id], $question_id);
        return response()->json(['status' => true], 200);
    }
}
