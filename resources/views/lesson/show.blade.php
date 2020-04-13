@extends('layout.master')

@section('title')
    @lang('lesson.show', ['name' => $lesson->name])
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">
            
            <!-- Course -->
            <div class="col-lg-12">
                
                <div class="course_container">
                    <div class="course_title">@lang('lesson.show', ['name' => $lesson->name])</div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_title">@lang('lesson.show', ['name' => $lesson->name])</div>
                                <div class="tab_panel_content">
                                    {{ $lesson->description }}
                                    <div id="accordion">
                                        <div class="list-questions">
                                            @foreach ($lesson->questions()->get() as $question)
                                                @include('lesson.question')
                                            @endforeach
                                        </div>

                                        <div class="card">
                                            <div class="card-header text-center">
                                                <a class="card-link text-secondary" data-toggle="modal" data-target="#add-question-form">
                                                    @lang('lesson.add_question')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="course_footer">
                        @admin
                            <div class="courses_button trans_200"><a href="{{ route('lesson.edit', $lesson->id) }}">@lang('common.edit')</a></div>
                            <div class="courses_button trans_200">
                                <form action="{{ route('lesson.destroy', $lesson->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">@lang('common.delete')</button>
                                </form>
                            </div>
                        @endadmin
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="add-question-form">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lesson.add_question')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="POST">
                    @csrf
                    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="question" id="question" placeholder="Question Content">
                    </div>
                    <div class="input-group mb-3">
                        <select name="type" id="type" class="form-control">
                            @foreach (Helper::getQuestionTypes() as $item => $key)
                            <option value="{{ $item }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">@lang('lesson.add_question')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-question-form">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lesson.edit_question')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="question" id="question" placeholder="Question Content">
                    </div>
                    <div class="input-group mb-3">
                        <select name="type" id="type" class="form-control">
                            @foreach (Helper::getQuestionTypes() as $item => $key)
                            <option value="{{ $item }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">@lang('common.edit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    if ($("#add-question-form form").length > 0) {
        $("#add-question-form form").on('submit', function(){
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('question.store') }}" ,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function( response ) {
                    if (response.status) {
                        $('.list-questions').append(response.view);
                        $('#add-question-form').modal('hide');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })
    };

    $('.list-questions').on('click', '#question-del-btn', function() {
        var url = $(this).data('url');
        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    $('#question-' + response.question_id).remove();
                }
            },
        });
    });

    $('.list-questions').on('click', '#question-edit-btn', function() {
        var target = $(this);
        var url = target.data('url');
        if ($("#edit-question-form form").length > 0) {
            $('#edit-question-form').find('input[name="question"]').val(target.parent().parent().find('span.question-content').text());
            $('#edit-question-form').find('option[value="' + target.parent().parent().parent().data('type') + '"]').prop('selected', true);
            $("#edit-question-form form").on('submit', function(){
                var formData = $('#edit-question-form form').serialize();
                $.ajax({
                    url: url,
                    type: "PATCH",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function( response ) {
                        if (response.status) {
                            $('#question-' + response.question_id).replaceWith(response.view);
                            $('#edit-question-form').modal('hide');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })
        };
    });
    
    if ($(".add-answer-form").length > 0) {
        $('.list-questions').on('submit', '.add-answer-form', function(){
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('answer.store') }}" ,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function( response ) {
                    if (response.status) {
                        $('.list-questions').find('#question-' + response.question.id).replaceWith(response.view);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })
    };

    $('.list-questions').on('click', '#answer-del-btn', function() {
        var url = $(this).data('url');
        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    $('#answer-' + response.answer_id).remove();
                }
            },
        });
    });
    
    $('.list-questions').on('click', '#answer-edit-btn', function() {
        var old_html = $(this).parent().parent().find('.float-left').html();
        var val = $(this).parent().parent().find('.float-left span').text();
        var url = $(this).data('url');
        $(this).parent().parent().find('.float-left').html("<input id='answer-update' class='form-control' name='answer' type='text' value='" + val + "'>");
        $('#answer-update').focusout(function(){
            var answer = $(this).val();
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    answer: answer
                },
                success: function(response) {
                    if (response.status) {
                        $('#answer-update').parent().html(old_html).find('span').text(answer);
                    }
                },
            });
        })
    });

    $('.list-questions').on('change', 'input.right-answer-btn', function() {
        var target = $(this);
        var answer_id = target.val();
        var question_id = target.data('question');
        var url = target.data('url');
        var prop = target.prop('checked');
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'answer_id': answer_id,
                'question_id': question_id,
                'prop': prop,
            },
            success: function(response) {
                if (response.status) {
                    $('.list-questions').find('#question-' + question_id).replaceWith(response.view);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    
</script>

@endsection
