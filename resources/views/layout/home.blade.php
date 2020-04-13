@extends('layout.master')

@section('title')
@lang('common.home')
@endsection

@section('content')


<!-- Popular Courses -->

<div class="courses">
    <div class="section_background"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section_title_container text-center">
                    <h2 class="section_title">Popular Online Courses</h2>
                    <div class="section_subtitle"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p></div>
                </div>
            </div>
        </div>

        <div class="row courses_row">
            @if ($courses)
                @foreach ($courses as $course)
                    <div class="col-lg-4 course_col">
                        <div class="course">
                            <div class="course_image"><img src="{{ asset('storage/uploads/' . $course->image) }}"></div>
                            <div class="course_body">
                                <h3 class="course_title"><a href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a></h3>
                                <div class="course_text">
                                    {{ Str::words($course->description, 15) }}
                                </div>
                            </div>
                            <div class="course_footer">
                                <div class="courses_button trans_200"><a href="{{ route('user.choose_course', $course->id) }}">@lang('course.learn')</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="noti-wrapper">
                    <span class="noti-error">
                        @lang('course.noti_no_course')
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
