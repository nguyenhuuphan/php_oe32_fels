<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Helper;

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
        $inputs = $request->all();
        $image = $request->file('image');
        $audio = $request->file('audio');
        if ($image) {
            $storage = Storage::disk('public')->put('words', $image);
            $inputs['image'] = $storage;
        }
        if ($audio) {
            $storage = Storage::disk('public')->put('audios', $audio);
            $inputs['audio'] = $storage;
        }
        $new = $this->wordRepository->create($inputs);
        $new['image'] = asset('storage/uploads/' . $new['image']);
        $new['audio'] = asset('storage/uploads/' . $new['audio']);
        $new['type'] = Helper::getWordType(intval($new['type']));
        $updateUrl = route('word.edit', $new['id']);
        $destroyUrl = route('word.destroy', $new['id']);

        return response()->json(['status' => true, 'new' => $new, 'updateUrl' => $updateUrl, 'destroyUrl' => $destroyUrl], 200);
    }

    public function edit($word_id)
    {
        $word = $this->wordRepository->find($word_id);

        return view('course.edit_word', compact('word'));
    }

    public function update(Request $request, $word_id)
    {

        $word = $this->wordRepository->find($word_id);
        $inputs = $request->all();
        $image = $request->file('image');
        $audio = $request->file('audio');

        if ($image) {
            $storage = Storage::disk('public')->put('words', $image);
            $inputs['image'] = $storage;
            Storage::disk('public')->delete($word->image);
        }
        if ($audio) {
            $storage = Storage::disk('public')->put('audios', $audio);
            $inputs['audio'] = $storage;
            Storage::disk('public')->delete($word->audio);
        }
        $this->wordRepository->update($inputs, $word_id);
        return redirect()->route('course.words', ['id' => $word->course->id]);
    }

    public function destroy($word_id)
    {
        $word = $this->wordRepository->find($word_id);
        $this->wordRepository->delete($word_id);
        Storage::disk('public')->delete($word->image);
        Storage::disk('public')->delete($word->audio);

        return response()->json(['status' => true, 'word_id' => $word_id], 200);
    }
}
