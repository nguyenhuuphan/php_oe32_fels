<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\AnswerRepository;

class AnswerController extends Controller
{
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function store(Request $request)
    {
        $this->answerRepository->create($request->all());
        return redirect()->back();
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
}
