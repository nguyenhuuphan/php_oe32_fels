@extends('layout.master')

@section('title')
    @lang('course.lesson_title', ['lesson' => $lesson->name, 'course' => $course->name])
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">
            
            <!-- Course -->
            <div class="col-lg-12">
                
                <div class="course_container">
                    <div class="course_title">@lang('course.lesson_title', ['lesson' => $lesson->name, 'course' => $course->name])</div>
                    
                    @if (Session::has('message'))
                        <div class="alert alert-danger" role="alert">{{ Session::get('message') }}</div>
                    @endif

                    <div class="progress-bar">
                        @if (Session::has('questions'))
                            @php
                                $answers = count(Session::get('questions'));
                            @endphp
                        @else
                            @php
                                $answers = 0;
                            @endphp
                        @endif
                        @php
                            $questions = count($lesson->questions()->get());
                            $percent = ($answers / $questions) * 100;
                        @endphp
                        <div class="progress">
                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:{{ $percent }}%">
                                <span class="answers">{{ $answers }}</span>
                                 / 
                                <span class="questions">{{ $questions }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_content">
                                    <div id="accordion">
                                        @foreach ($lesson->questions()->get() as $question)
                                            @if (Session::has('questions'))
                                                @if (in_array($question->id, Session::get('questions')))
                                                    @php
                                                        $check = true
                                                    @endphp
                                                @else
                                                    @php
                                                        $check = false
                                                    @endphp
                                                @endif
                                            @else
                                                @php
                                                    $check = false
                                                @endphp
                                            @endif

                                            @if ($check)
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a class="card-link text-info" data-toggle="collapse" href="#collapse-{{ $question->id }}">
                                                            {{ $loop->iteration . '. ' .$question->question }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a class="card-link text-secondary" data-toggle="collapse" href="#collapse-{{ $question->id }}">
                                                            {{ $loop->iteration . '. ' .$question->question }}
                                                        </a>
                                                    </div>
                                                    <div id="collapse-{{ $question->id }}" class="collapse" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <ol>
                                                                @foreach ($question->answers()->get() as $answer)
                                                                    <li>
                                                                        {{ $answer->answer }}
                                                                        <input
                                                                            data-question={{ $question->id }}
                                                                            data-url="{{ route('lesson.answer') }}"
                                                                            type="radio"
                                                                            name="question-{{ $question->id }}"
                                                                            class="answer-btn"
                                                                            value={{ $answer->id }}>
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="course_footer">
                        <div class="courses_button trans_200 mt-5">
                            <a href="{{ route('lesson.end_lesson', $course->id) }}">@lang('course.end_lesson')</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
