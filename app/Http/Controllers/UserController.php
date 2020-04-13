<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Enums\UserRole;

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        $users = $this->userRepository->paginate(15);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        $inputs = $request->all();
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
        
        $user = $this->userRepository->create($inputs);
        return redirect()->route('user.index')->with('created', $user->getKey());
    }

    public function destroy($id)
    {
        $user = $this->userRepository->find($id);
        $this->userRepository->delete($id);
        Storage::disk('public')->delete($user->avatar);
        return redirect()->route('user.index')->withErrors(['msg' => "User $user->name had been deleted!"]);
    }

    public function show($id)
    {
        try {
            $user = $this->userRepository->find($id);
        } catch (ModelNotFoundException $err) {
            return redirect()->back()->withErrors(['User Not Found']);
        }
        return view('user.show', compact('user'));
    }

    public function edit($user_id)
    {
        $user = $this->userRepository->find($user_id);
        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request, $user_id)
    {
        $user = $this->userRepository->find($user_id);
        $inputs = $request->except(['password_confirmation']);
        $image = $request->file('avatar');
        if ($image) {
            Storage::disk('public')->delete($user->avatar);
            $storage = Storage::disk('public')->put('avatars', $image);
            $inputs['avatar'] = $storage;
        }
        if ($inputs['password'] == null) {
            unset($inputs['password']);
        } else {
            $inputs['password'] = Hash::make($inputs['password']);
        }
        $this->userRepository->update($inputs, $user_id);

        if ($request->user()) {
            if ($request->user()->role == UserRole::Administrator) {
                return redirect()->route('user.index')->with('updated', $user_id);
            }
        }
        return redirect()->route('user.show', $user_id)->with('updated', $user_id);
    }

    public function chooseCourse(Request $request, $course_id)
    {
        if (count($request->user()->learningCourse)) {
            if ($request->user()->learningCourse->first()->id == $course_id) {
                return redirect()->route('course.show', $course_id)->with('chooseSuccess', $course_id);
            } else {
                return redirect()->back()->withErrors([trans('course.learn_error')]);
            }
        } else {
            $request->user()->courses()->attach($course_id);
            return redirect()->route('course.show', $course_id)->with('chooseSuccess', $course_id);
        }
    }
}
