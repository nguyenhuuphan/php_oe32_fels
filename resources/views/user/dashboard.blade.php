@extends('layout.master')

@section('title')
    @lang('common.dashboard') - {{ $user->name }}
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">

            <!-- Course -->
            <div class="col-lg-12">

                <div class="course_container">
                    <div class="course_title">@lang('common.dashboard'), {{ $user->name }}</div>
                    <!-- Course Tabs -->
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

                                            @if ($user->course()->first())
                                                <h4>@lang('dashboard.course') <a href="{{ route('course.show', $user->course()->first()->id) }}">{{ $user->course()->first()->name }}</a></h4>
                                                <h4><a href="{{ route('lesson.result', $user->course()->first()->id) }}">@lang('common.result')</a></h4>
                                            @else
                                                <h4>@lang('dashboard.course') <a href="{{ route('home') }}">@lang('dashboard.choose_course')</a></h4>
                                            @endif

                                            <h4>@lang('dashboard.word')</h4>
                                            @if (count($user->wordLearned()->get()) > 0)
                                                @foreach ($user->wordLearned()->get() as $word)
                                                    <span>{{ $word->name }}</span>
                                                @endforeach
                                            @else
                                                @lang('dashboard.no_word')
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
                                                    @if (count($follower->follower_user()->first()->activities()->get()) > 0)
                                                        <ul>
                                                            @foreach ($follower->follower_user()->first()->activities()->get() as $follower_activity)
                                                                <li>
                                                                    @lang('dashboard.activity', [
                                                                        'activity' => $follower_activity->activity,
                                                                        'date' => $follower_activity->created_at->format('H:i d-m-Y'),
                                                                    ])
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @elseif(count($follower->follower_user()->first()->activities()->get()) < 1)
                                                        @lang('dashboard.no_activity')
                                                    @endif
                                                @endforeach
                                            @else
                                                @lang('dashboard.no_following')
                                            @endif
                                            
                                        </div>
                                        <div class="course_footer mt-3">
                                            <div class="courses_button trans_200"><a href="{{ route('user.edit', $user->id) }}">@lang('dashboard.update')</a></div>
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
