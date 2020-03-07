<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth')->except('profile');
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        return view('user.dashboard', compact('user'));
    }

    public function profile($id)
    {
        $user = $this->userRepository->find($id);
        return view('user.profile', compact('user'));
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['password_confirmation']);
        $validator = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        $image = $request->file('avatar');
        if ($image) {
            $storage = Storage::disk('public')->put('avatars', $image);
            $inputs['avatar'] = $storage;
        }
        if ($inputs['password'] == null) {
            unset($inputs['password']);
        } else {
            $inputs['password'] = Hash::make($inputs['password']);
        }
        $this->userRepository->update($inputs, $request->user()->id);
        return redirect()->route('profile.dashboard');
    }

    public function chooseCourse(Request $request, $course_id)
    {
        $current_course = $request->user()->course()->first();
        if ($current_course) {
            if ($current_course->id == $course_id) {
                return redirect()->route('course.show', $course_id);
            } else {
                if ($request->user()->result->lesson->course->id === $course_id) {
                    $this->userRepository->update(['course_id' => $course_id], $request->user()->id);
                    return redirect()->route('course.show', $course_id);
                } else {
                    return redirect()->back()->withErrors(['Please finish your current course before starting another!']);
                }
            }
        }
        $this->userRepository->update(['course_id' => $course_id], $request->user()->id);
        return redirect()->route('course.show', $course_id);
    }
}
