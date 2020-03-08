@extends('layout.master')

@section('title')
    @lang('course.words_title', ['course' => $course->name])
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">
            
            <!-- Course -->
            <div class="col-lg-12">
                
                <div class="course_container">
                    <div class="course_title">@lang('course.words_title', ['course' => $course->name])</div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_content">
                                    <div class="row">
                                        @foreach ($words as $word)
                                            <div class="col-4 mb-2">
                                                <div class="row">
                                                    <div class="col-6 m-auto">
                                                        {{ $word->name }}
                                                    </div>
                                                    <div class="col-6 word-action">
                                                        <input
                                                            @auth
                                                                @if (auth::user()->wordLearned()->get()->contains('id', $word->id))
                                                                    {{ 'checked' }}
                                                                @endif
                                                            @endauth
                                                            class="word-toggle"
                                                            type="checkbox"
                                                            data-onstyle="success"
                                                            data-offstyle="primary"
                                                            data-size="mini"
                                                            data-toggle="toggle"
                                                            data-on="Learned"
                                                            data-off="Learn"
                                                            data-width="90"
                                                            data-height="30"
                                                            data-url="{{ route('user.word_learn', $word->id) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="course_footer">
                        @auth
                            @if (auth::user()->course()->first()->id == $course->id)
                                <div class="courses_button trans_200 mt-5"><a href="{{ route('course.lesson', $course->id) }}">@lang('course.lesson')</a></div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
