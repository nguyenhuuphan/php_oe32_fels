<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;
use App\Repositories\UserRepository;

use App\Http\Requests\UserRequest;

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
        $inputs = $request->except(['password_confirmation']);
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
}
