<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\WordRepository;

class WordController extends Controller
{
    private $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function store(Request $request)
    {
        $this->wordRepository->create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $word_id)
    {
        $this->wordRepository->update(['name' => $request->word], $word_id);
        return response()->json(['status' => true], 200);
    }

    public function destroy($word_id)
    {
        $this->wordRepository->delete($word_id);
        return response()->json(['status' => true, 'word_id' => $word_id], 200);
    }
}
