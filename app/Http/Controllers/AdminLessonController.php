<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LessonRepository;
use App\Repositories\CourseRepository;

class AdminLessonController extends Controller
{
    private $lessonRepository;
    private $courseRepository;

    public function __construct(LessonRepository $lessonRepository, CourseRepository $courseRepository)
    {
        $this->lessonRepository = $lessonRepository;
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        $lessons = $this->lessonRepository->all();
        return view('lesson.index', compact('lessons'));
    }

    public function show($id, Request $request)
    {
        try {
            $lesson = $this->lessonRepository->find($id);
        } catch (ModelNotFoundException $err) {
            return redirect()->back()->withErrors(['Lesson Not Found']);
        }
        return view('lesson.show', compact('lesson', 'request'));
    }

    public function create()
    {
        $courses = $this->courseRepository->all();
        return view('lesson.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $lesson = $this->lessonRepository->create($inputs);

        return redirect()->route('lesson.show', ['id' => $lesson->id]);
    }

    public function edit($lesson_id)
    {
        $courses = $this->courseRepository->all();
        $lesson = $this->lessonRepository->find($lesson_id);
        return view('lesson.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, $lesson_id)
    {
        $inputs = $request->all();
        $lesson = $this->lessonRepository->update($inputs, $lesson_id);

        return redirect()->route('lesson.show', ['id' => $lesson_id]);
    }

    public function destroy($lesson_id)
    {
        $lesson = $this->lessonRepository->find($lesson_id);
        $this->lessonRepository->delete($lesson_id);
        return redirect()->route('home')->withErrors(['msg' => "Lesson $lesson->name had been deleted!"]);
    }
}
