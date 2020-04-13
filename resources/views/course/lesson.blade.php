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
                        <div class="progress under-bar">
                            <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" style="width:100%"></div>
                        </div>
                        <div class="progress upper-bar" style="width:{{ $percent }}%">
                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:100%">
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
                                            @include('lesson.question')
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

<script>
    $('#accordion').on('change', 'input.answer-single', function() {
        var target = $(this);
        var answer_id = target.val();
        var question_id = target.data('question');
        $.ajax({
            type: "POST",
            url: "{{ route('lesson.answerSingle') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'answer_id': answer_id,
                'question_id': question_id,
            },
            success: function(response) {
                if (response.flag) {
                    $("#answer-"+ answer_id).addClass('text-success');
                } else {
                    $("#answer-"+ answer_id).addClass('text-danger');
                    $("#answer-"+ response.right_answer).addClass('text-success');
                }
                target.parent().parent().find('li input.answer-single').prop('disabled', true);
                target.parent().parent().find('li:not(".text-success")').addClass('text-secondary text-strike');

                var questions_count = $('.progress-bar span.questions').text();
                var percent = (response.answered / questions_count) * 100;
                target.closest('.card').find('a.card-link').addClass('text-info');
                $('.progress-bar span.answers').text(response.answered);
                $('.progress-bar .progress.upper-bar').css({
                    'width': percent + '%',
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $('#accordion').on('change', 'input.answer-multiple', function() {
        var target = $(this);
        var answers = target.parent().parent().data('answers');
        var answered_count = target.parent().parent().find('li input.answer-multiple:checked').length;
        if (answered_count == answers) {
            var answers_id = [];
            var question_id = target.data('question');
            var prop = target.prop('checked');
            target.parents().find('li input.answer-multiple:checked').each(function() {
                answers_id.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: "{{ route('lesson.answerMultiple') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'answers_id': answers_id,
                    'question_id': question_id,
                },
                success: function(response) {
                    if (response.flag) {
                        answers_id.forEach(element => {
                            $('#answer-' + element).addClass('text-success');
                        });
                    } else {
                        var right_answers = response.right_answers;
                        answers_id.forEach(element => {
                            $('#answer-' + element).addClass('text-danger');
                        });
                        right_answers.forEach(element => {
                            $('#answer-' + element).addClass('text-success').removeClass('text-danger');
                        });
                    }
                    target.parent().parent().find('li input.answer-multiple').prop('disabled', true);
                    target.parent().parent().find('li:not(".text-success")').addClass('text-secondary text-strike');

                    var questions_count = $('.progress-bar span.questions').text();
                    var percent = (response.answered / questions_count) * 100;
                    target.closest('.card').find('a.card-link').addClass('text-info');
                    $('.progress-bar span.answers').text(response.answered);
                    $('.progress-bar .progress.upper-bar').css({
                        'width': percent + '%',
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    if ($(".answer-fillable").length > 0) {
        $(".answer-fillable").on('submit', function(){
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('lesson.answerFillable') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function( response ) {
                    if (response.flag) {
                        $('.answer-fillable input#answer').addClass('border-success');
                    } else {
                        $('.answer-fillable input#answer').addClass('border-danger');
                        $('.answer-fillable').parent().find('span.right-answer').text(response.right_answer);
                    }
                    $('.answer-fillable input').prop('disabled', true);

                    var questions_count = $('.progress-bar span.questions').text();
                    var percent = (response.answered / questions_count) * 100;
                    $(".answer-fillable").closest('.card').find('a.card-link').addClass('text-info');
                    $('.progress-bar span.answers').text(response.answered);
                    $('.progress-bar .progress.upper-bar').css({
                        'width': percent + '%',
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })
    };
</script>
@endsection
