<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\WordLearnRepository;

class WordLearnController extends Controller
{
    private $wordLearnRepository;
    public function __construct(WordLearnRepository $wordLearnRepository)
    {
        $this->middleware('auth');
        $this->wordLearnRepository = $wordLearnRepository;
    }

    public function wordLearn(Request $request, $word_id)
    {
        if($request->ajax()) {
            if($request->check == 'true') {
                $this->wordLearnRepository->create(['user_id' => $request->user()->id, 'word_id' => $word_id]);
                return response()->json(array('flag'=> true), 200);
            } else {
                $this->wordLearnRepository->unLearn(['user_id' => $request->user()->id, 'word_id' => $word_id]);
                return response()->json(array('flag'=> false), 200);
            }
        }
    }
}
