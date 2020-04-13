@extends('layout.master')

@section('title')
    @lang('course.show', ['name' => $course->name])
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">
            
            <!-- Course -->
            <div class="col-lg-12">
                
                <div class="course_container">
                    <div class="course_title">@lang('course.show', ['name' => $course->name])</div>
                    
                    <!-- Course Image -->
                    <div class="course_image"><img src="{{ asset('storage/uploads/' . $course->image) }}"></div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_title">@lang('course.show', ['name' => $course->name])</div>
                                <div class="tab_panel_content">
                                    {{ $course->description }}
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="course_footer">
                        @admin
                            <div class="courses_button trans_200"><a href="{{ route('course.edit', $course->id) }}">@lang('common.edit')</a></div>
                            <div class="courses_button trans_200">
                                <form action="{{ route('course.destroy', $course->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">@lang('common.delete')</button>
                                </form>
                            </div>
                            <div class="courses_button trans_200"><a href="{{ route('course.words', $course->id) }}">@lang('course.words')</a></div>
                            @if ($course->lesson)
                                <div class="courses_button trans_200"><a href="{{ route('lesson.show', $course->lesson->id) }}">@lang('lesson.edit', ['name' => $course->lesson->name])</a></div>
                            @else
                                <div class="courses_button trans_200"><a href="{{ route('lesson.create') }}">@lang('lesson.create')</a></div>
                            @endif
                        @endadmin
                        @if (auth::check())
                            @if (auth::user()->learningCourse->first())
                                @if (auth::user()->learningCourse->first()->id == $course->id)
                                    <div class="courses_button trans_200"><a href="{{ route('course.words', $course->id) }}">@lang('course.words')</a></div>
                                    <div class="courses_button trans_200"><a href="{{ route('course.lesson', $course->id) }}">@lang('course.lesson')</a></div>
                                @endif
                            @else
                                <div class="courses_button trans_200"><a href="{{ route('user.choose_course', $course->id) }}">@lang('course.learn')</a></div>
                            @endif
                        @else
                            <div class="courses_button trans_200"><a href="{{ route('user.choose_course', $course->id) }}">@lang('course.learn')</a></div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
