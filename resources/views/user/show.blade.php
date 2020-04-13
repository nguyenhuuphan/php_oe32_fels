@extends('layout.master')

@section('title')
    @lang('user.title'): {{ $user->name }}
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">

            <!-- Course -->
            <div class="col-lg-12">
                <div class="course_container">

                    <div class="course_title">@lang('user.title'): {{ $user->name }}</div>
                    <!-- Course Tabs -->
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                    <div class="course_tabs_container">
                        <div class="user-profile">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <img src="{{ asset('storage/uploads/' . $user->avatar) }}" alt="" class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-sm-6 col-md-8">
                                        <h4>{{ $user->name }}</h4>
                                        <p><i class="glyphicon glyphicon-envelope"></i>{{ $user->email }}</p>
                                        <div class="course-content">

                                            @if (count($user->courses))
                                                <h4>@lang('dashboard.learned_course')</h4>
                                                <ol>
                                                    @foreach ($user->courses as $course)
                                                        @if ($course->pivot->status == 1)
                                                            <li class="ml-5">
                                                                <a href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a>
                                                                    | 
                                                                <a href="{{ route('lesson.result', $course->id) }}">@lang('common.result')</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ol>
                                                @if ($user->learningCourse->first())
                                                    <h4>@lang('dashboard.course') <a href="{{ route('course.show', $user->learningCourse->first()->id) }}">{{ $user->learningCourse->first()->name }}</a></h4>
                                                @else
                                                    <h4>@lang('dashboard.course') <a href="{{ route('home') }}">@lang('dashboard.choose_course')</a></h4>
                                                @endif
                                            @else
                                                <h4>@lang('dashboard.course') <a href="{{ route('home') }}">@lang('dashboard.choose_course')</a></h4>
                                            @endif

                                            @if (count($user->wordLearned()->get()) > 0)
                                                @foreach ($user->wordLearned()->get() as $word)
                                                    <span>{{ $word->name }}</span>
                                                @endforeach
                                            @endif

                                            <h4>@lang('dashboard.activities')</h4>
                                            @if (count($user->activities()->get()) > 0)
                                                <ul>
                                                    @foreach ($user->activities()->get() as $activity)
                                                        <li>
                                                            @lang('dashboard.activity', [
                                                                'activity' => $activity->activity,
                                                                'date' => $activity->created_at->format('H:i d-m-Y'),
                                                            ])
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                @lang('dashboard.no_activity')
                                            @endif

                                            <h4>@lang('dashboard.followings')</h4>
                                            @if (count($user->followers()->get()) > 0)
                                                @foreach ($user->followers()->get() as $follower)
                                                    <h5>
                                                        <a href="{{ route('user.show', $follower->follower_user()->first()->id) }}">
                                                            {{ $follower->follower_user()->first()->name }}
                                                        </a>
                                                    </h5>
                                                    @if (auth::user()->followers()->get('follower_id')->contains('follower_id', $follower->follower_user()->first()->id))
                                                        @if (count($follower->follower_user->activities()->get()) > 0)
                                                            <ul>
                                                                @foreach ($follower->follower_user->activities()->get() as $activity)
                                                                    <li>
                                                                        @lang('dashboard.activity', [
                                                                            'activity' => $activity->activity,
                                                                            'date' => $activity->created_at->format('H:i d-m-Y'),
                                                                        ])
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            @lang('dashboard.no_activity')
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else
                                                @lang('dashboard.no_following')
                                            @endif
                                            
                                        </div>
                                        <div class="course_footer mt-3">
                                            @auth
                                                @if (auth::user()->id !== $user->id)
                                                    @if (!auth::user()->followers()->get('follower_id')->contains('follower_id', $user->id))
                                                        <div class="courses_button trans_200"><a href="{{ route('user.follow', $user->id) }}">@lang('common.follow')</a></div>
                                                    @endif
                                                @else
                                                    <div class="courses_button trans_200"><a href="{{ route('user.edit', $user->id) }}">@lang('dashboard.update')</a></div>
                                                @endif
                                                @admin
                                                    <div class="courses_button trans_200"><a href="{{ route('user.edit', $user->id) }}">@lang('dashboard.update')</a></div>
                                                @endadmin
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
