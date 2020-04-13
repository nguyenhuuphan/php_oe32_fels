<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\WordLearnRepository;
use App\Repositories\CourseRepository;
use App\Repositories\WordRepository;

class WordLearnController extends Controller
{
    private $wordLearnRepository;
    private $courseRepository;
    private $wordRepository;
    public function __construct(WordLearnRepository $wordLearnRepository, CourseRepository $courseRepository, WordRepository $wordRepository)
    {
        $this->middleware('auth');
        $this->wordLearnRepository = $wordLearnRepository;
        $this->courseRepository = $courseRepository;
        $this->wordRepository = $wordRepository;
    }

    public function learning($course_id)
    {
        $course = $this->courseRepository->find($course_id);
        $words = $course->words()->get();

        return view('course.learning', compact('course', 'words'));
    }

    public function wordLearning(Request $request)
    {
        if($request->ajax()) {
            $word_id = $request->word_id;
            $word = $this->wordRepository->find($word_id);
            $answer = $request->word_answer;
            $data = null;
            if ($answer != null) {
                if (strtolower($word->name) === strtolower($answer)) {
                    if (!$request->user()->wordLearned->contains('id', $word_id)) {
                        $this->wordLearnRepository->create(['user_id' => $request->user()->id, 'word_id' => $word_id]);
                    }
                    $data = [
                        'flag' => true,
                        'right_word' => $word->name,
                    ];
                } else {
                    $data = [
                        'flag' => false,
                        'wrong_word' => $word->name,
                    ];
                }
            }
            return response()->json(array('data'=> $data), 200);
        }
    }
}
