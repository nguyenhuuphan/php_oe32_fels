<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\FollowerRepository;

class FollowerController extends Controller
{
    private $followerRepository;
    public function __construct(FollowerRepository $followerRepository)
    {
        $this->middleware('auth');
        $this->followerRepository = $followerRepository;
    }

    public function following(Request $request, $id)
    {
        if ($request->user()->followers()->get()->contains('follower_id', $id)) {
            return redirect()->back()->withErrors(['You\'d followed this User!']);
        }
        $this->followerRepository->create(['user_id' => $request->user()->id, 'follower_id' => $id]);
        return redirect()->back()->withErrors(['You follow this User!']);
    }
}
