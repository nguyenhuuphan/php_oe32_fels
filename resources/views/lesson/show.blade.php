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
                                        @foreach ($lesson->questions()->get() as $question)
                                            <div class="card" id="question-{{ $question->id }}">
                                                <div class="card-header clear-fix">
                                                    <div class="float-left card-link-wrapper">
                                                        <a class="card-link text-secondary" data-toggle="collapse" href="#collapse-{{ $question->id }}">
                                                            {!! $loop->iteration . '. <span>' .$question->question . '</span>' !!}
                                                        </a>
                                                    </div>
                                                    <div class="float-right">
                                                        <a id="question-edit-btn" data-url="{{ route('question.update', $question->id) }}" data-id={{ $question->id }}>@lang('common.edit')</a>
                                                         | 
                                                        <a id="question-del-btn" data-url="{{ route('question.destroy', $question->id) }}" data-id={{ $question->id }}>@lang('common.delete')</a>
                                                    </div>
                                                </div>
                                                <div id="collapse-{{ $question->id }}" class="collapse" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <ul style="list-style-type: circle">
                                                            @foreach ($question->answers()->get() as $answer)
                                                                <li class="clear-fix" id="answer-{{ $answer->id }}">
                                                                    <div class="float-left">
                                                                        @if ($question->answer_id === $answer->id)
                                                                            <span class="text-success">{{ $answer->answer }}</span>
                                                                            <input
                                                                                checked
                                                                                data-question={{ $question->id }}
                                                                                data-url="{{ route('question.right_answer') }}"
                                                                                type="radio"
                                                                                name="question-{{ $question->id }}"
                                                                                class="right-answer-btn"
                                                                                value={{ $answer->id }}>
                                                                        @else
                                                                            <span>{{ $answer->answer }}</span>
                                                                            <input
                                                                                data-question={{ $question->id }}
                                                                                data-url="{{ route('question.right_answer') }}"
                                                                                type="radio"
                                                                                name="question-{{ $question->id }}"
                                                                                class="right-answer-btn"
                                                                                value={{ $answer->id }}>
                                                                        @endif
                                                                    </div>
                                                                    <div class="float-right">
                                                                        <a id="answer-edit-btn" data-url="{{ route('answer.update', $answer->id) }}" data-id={{ $answer->id }}>@lang('common.edit')</a>
                                                                         | 
                                                                        <a id="answer-del-btn" data-url="{{ route('answer.destroy', $answer->id) }}" data-id={{ $answer->id }}>@lang('common.delete')</a>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                            <li><a class="add-answer-form-btn" data-id={{ $question->id }} data-toggle="modal" data-target="#add-answer-form">@lang('lesson.add_answer')</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

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
                <form action="{{ route('question.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="question" id="question" placeholder="Question Content">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">@lang('lesson.add-question')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-answer-form">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lesson.add_answer')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('answer.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="question_id" value="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="answer" id="answer" placeholder="Answer Content">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">@lang('lesson.add-answer')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
