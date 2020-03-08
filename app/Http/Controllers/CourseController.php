<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Course;
use App\Repositories\CourseRepository;

class CourseController extends Controller
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        $courses = $this->courseRepository->all();
        return view('layout.home', compact('courses'));
    }

    public function show($id, Request $request)
    {
        try {
            $course = $this->courseRepository->find($id);
        } catch (ModelNotFoundException $err) {
            return redirect()->back()->withErrors(['Course Not Found']);
        }
        return view('course.show', compact('course', 'request'));
    }

    public function create()
    {
        return view('course.create');
    }

    public function store(Request $request)
    {
        $image = $request->file('image');
        if ($image) {
            $storage = Storage::disk('public')->put('courses', $image);
        }

        $inputs = $request->all();
        $inputs['image'] = $storage;
        $course = $this->courseRepository->create($inputs);

        return redirect()->route('course.show', ['id' => $course->id]);
    }

    public function edit($course_id)
    {
        $course = $this->courseRepository->find($course_id);
        return view('course.edit', compact('course'));
    }

    public function update(Request $request, $course_id)
    {
        $course = $this->courseRepository->find($course_id);
        $image = $request->file('image');
        $inputs = $request->all();
        if ($image) {
            Storage::disk('public')->delete($course->image);
            $storage = Storage::disk('public')->put('courses', $image);
            $inputs['image'] = $storage;
        }

        $course = $this->courseRepository->update($inputs, $course_id);

        return redirect()->route('course.show', ['id' => $course_id]);
    }

    public function destroy($course_id)
    {
        $course = $this->courseRepository->find($course_id);
        $this->courseRepository->delete($course_id);
        Storage::disk('public')->delete($course->image);
        return redirect()->route('home')->withErrors(['msg' => "Course $course->name had been deleted!"]);
    }

    public function words($course_id)
    {
        $course = $this->courseRepository->find($course_id);
        $words = $course->words()->get();
        return view('course.words', compact('course', 'words'));
    }

    public function lesson($course_id)
    {
        $course = $this->courseRepository->find($course_id);
        $lesson = $course->lesson()->first();
        return view('course.lesson', compact('course', 'lesson'));
    }
}
