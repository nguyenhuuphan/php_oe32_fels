@extends('layout.master')

@section('title')
@lang('course.learning_title', ['course' => $course->name])
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">
            
            <!-- Course -->
            <div class="col-lg-12">
                
                <div class="course_container">
                    <div class="course_title clear-fix">
                        <span class="float-left">@lang('course.learning_title', ['course' => $course->name])</span>
                    </div>

                    <div class="progress-bar">
                        <div class="progress under-bar">
                            <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" style="width:100%"></div>
                        </div>
                        <div class="progress upper-bar" width="0%">
                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:100%">
                                <span class="answers">0</span>
                                 / 
                                <span class="questions">{{ count($words) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_content">
                                    <div class="row list-words list-words-exercise">
                                        @foreach ($words as $word)
                                        <div class="col-12 mb-2 word-exercise @if ($loop->first) current-exercise @elseif($loop->last) last-excercise @endif " id="word-{{ $word->id }}">
                                            <div class="row">
                                                <div class="col-3 word-image">
                                                    <img src="{{ asset('storage/uploads/' . $word->image) }}">
                                                </div>
                                                <div class="col-4 word-info">
                                                    <p class="m-0 word-def">{{ $word->def }}</p>
                                                    <p class="m-0 word-spelling">{{ $word->spelling }}</p>
                                                    <p class="m-0 word-mean">{{ $word->mean }}</p>
                                                    <p class="m-0 word-type">{{ Helper::getWordType($word->type) }}</p>
                                                    <span class="word-audio">
                                                        <a class="item-sound main-sound-play" href="javascript:void(0)" sound_url="{{ asset('storage/uploads/' . $word->audio) }}"></a>
                                                    </span>
                                                </div>
                                                <div class="col-5 word-answer-field">
                                                    <form action="javascript:void(0)" method="post" class="answer-form">
                                                        <input type="hidden" name="word_id" value="{{ $word->id }}">
                                                        <div class="form-group">
                                                          <input required type="text" name="word_answer" id="word-answer" class="form-control" placeholder="@lang('course.learning_answer')">
                                                        </div>
                                                        <button type="submit" class="btn btn-success">@lang('course.learning_btn_title')</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center mt-3 footer-learning">
                                            <span class="btn btn-info prev-exercise" href="javascript:void(0)"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('common.prev')</span>
                                            <span class="btn btn-info next-exercise" href="javascript:void(0)">@lang('common.next') <i class="fa fa-arrow-right" aria-hidden="true"></i></span>
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

<div class="modal fade" id="word-learning-result">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('course.word_learning_result')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="result">
                    <span><b>@lang('common.result'):</b></span>
                    <span class="text-content text-success"></span>
                </div>
                <div class="right-words">
                    <span class="text-success"><b>@lang('course.right_words'):</b></span>
                </div>
                <div class="wrong-words">
                    <span class="text-danger"><b>@lang('course.wrong_words'):</b></span>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" href="{{ route('course.learning', $course->id) }}">@lang('common.restart')</a>
                <a class="btn btn-info" href="{{ route('course.lesson', $course->id) }}">@lang('course.lesson')</a>
            </div>
        </div>
    </div>
</div>

<script>
    if ($("form.answer-form").length > 0) {
        $("form.answer-form").on('submit', function(el){
            var target = $(this);
            var formData = new FormData(this);
            var answers = parseInt($('.progress-bar .answers').text()) +1;
            var words = {{ count($words) }};
            var percent = (answers) / words * 100;
            
            $.ajax({
                url: "{{ route('word.word_learning') }}" ,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function( response ) {
                    if (response.data != null) {
                        target.find('input[name="word_answer"]').prop('disabled', true);
                        $('.progress-bar .answers').text(answers);
                        $('.progress-bar .progress.upper-bar').width(percent + '%');

                        if (response.data.flag) {
                            target.find('input[name="word_answer"]').addClass('border border-success');
                            $('#word-learning-result .right-words').append('<span class="text-content">' + response.data.right_word + '</span>');
                        } else {
                            target.find('input[name="word_answer"]').addClass('border border-danger');
                            $('#word-learning-result .wrong-words').append('<span class="text-content">' + response.data.wrong_word + '</span>');
                        }

                        if(target.parents().hasClass('last-excercise')) {
                            $('#word-learning-result').modal('show');
                            $('.footer-learning').append('<p class="text-center mt-3"><span class="btn btn-info" data-toggle="modal" data-target="#word-learning-result">@lang('common.result')</span></p>');
                        }
                    }

                    $('#word-learning-result .result .text-content').text($('#word-learning-result .right-words').find('span.text-content').length + ' / ' + words);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })
    };

    $('.footer-learning').on('click', '.next-exercise', function() {
        var target = $('.list-words-exercise').find('.current-exercise');
        if(target.next().length > 0) {
            target.next().addClass('current-exercise');
            target.removeClass('current-exercise');
        }
    });

    $('.footer-learning').on('click', '.prev-exercise', function() {
        var target = $('.list-words-exercise').find('.current-exercise');
        if(target.prev().length > 0) {
            target.prev().addClass('current-exercise');
            target.removeClass('current-exercise');
        }
    });
</script>
@endsection
