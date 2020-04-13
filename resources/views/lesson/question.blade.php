@if (Route::currentRouteName() == 'course.lesson')
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
        <div class="card" id="question-{{ $question->id }}" data-type="{{ $question->type }}">
            <div class="card-header">
                <a class="card-link text-info" data-toggle="collapse" href="#collapse-{{ $question->id }}">
                    {{ $loop->iteration . '. ' .$question->question }}
                </a>
                <p class="question-type">@lang('common.type'): {{ Helper::getQuestionType($question->type) }}</p>
            </div>
        </div>
    @else
        <div class="card" id="question-{{ $question->id }}" data-type="{{ $question->type }}">
            <div class="card-header">
                <a class="card-link text-secondary" data-toggle="collapse" href="#collapse-{{ $question->id }}">
                    {{ $loop->iteration . '. ' .$question->question }}
                </a>
                <p class="question-type">@lang('common.type'): {{ Helper::getQuestionType($question->type) }}</p>
            </div>
            <div id="collapse-{{ $question->id }}" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    @switch(strtolower(Helper::getQuestionType($question->type)))
                        @case('single')
                            <ol>
                                @foreach ($question->answers()->get() as $answer)
                                    <li id="answer-{{ $answer->id }}">
                                        {{ $answer->answer }}
                                        <input
                                            data-question={{ $question->id }}
                                            type="radio"
                                            name="question-{{ $question->id }}"
                                            class="answer-single"
                                            value={{ $answer->id }}>
                                    </li>
                                @endforeach
                            </ol>
    
                            @break
    
                        @case('multiple')
                            <p>@lang('lesson.answers_number', ['count' => count($question->answers->where('status', 1))])</p>
                            <ol data-answers={{ count($question->answers->where('status', 1)) }}>
                                @foreach ($question->answers()->get() as $answer)
                                    <li id="answer-{{ $answer->id }}">
                                        {{ $answer->answer }}
                                        <input
                                            data-question={{ $question->id }}
                                            type="checkbox"
                                            name="question-{{ $question->id }}"
                                            class="answer-multiple"
                                            value={{ $answer->id }}>
                                    </li>
                                @endforeach
                            </ol>
                            
                            @break
    
                        @case('fillable')
                                @lang('common.answer'): <span class="right-answer text-success"></span>
                                <form action="javascript:void(0)" method="post" class="answer-fillable">
                                    @csrf
                                    <input type="hidden" name="question_id" value={{ $question->id }}>
                                    <div class="input-group w-50 mb-3">
                                        <input type="text" class="form-control" placeholder="@lang('common.answer')" name="answer" id="answer">
                                        <div class="input-group-append">
                                            <input class="btn btn-success" type="submit" value="@lang('common.answer')">
                                        </div>
                                    </div>
                                </form>
    
                            @break
                        @default
                            
                    @endswitch
                </div>
            </div>
        </div>
    @endif
@else
    <div class="card" id="question-{{ $question->id }}" data-type="{{ $question->type }}">
        <div class="card-header clear-fix">
            <div class="float-left card-link-wrapper">
                <a class="card-link text-secondary" data-toggle="collapse" href="#answers-{{ $question->id }}">
                    <i class="fas fa-question-circle"></i>
                    <span class="question-content">{{ $question->question }}</span>
                    <p class="question-type">@lang('common.type'): {{ Helper::getQuestionType($question->type) }}</p>
                </a>
            </div>
            <div class="float-right">
                <a data-toggle="modal" data-target="#edit-question-form" id="question-edit-btn" data-url="{{ route('question.update', $question->id) }}" data-id={{ $question->id }}>@lang('common.edit')</a>
                    | 
                <a id="question-del-btn" data-url="{{ route('question.destroy', $question->id) }}" data-id={{ $question->id }}>@lang('common.delete')</a>
            </div>
        </div>
        <div id="answers-{{ $question->id }}" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                @switch(strtolower(Helper::getQuestionType($question->type)))
                    @case('single')
                        <ul style="list-style-type: circle" class="list-answers">
                            @if (count($question->answers))
                                @foreach ($question->answers as $answer)
                                    <li class="clear-fix" id="answer-{{ $answer->id }}">
                                        <div class="float-left">
                                            @if ($answer->status == 1)
                                                <span class="text-success">{{ $answer->answer }}</span>
                                                <input
                                                    checked
                                                    data-question={{ $question->id }}
                                                    data-url="{{ route('answer.right_answer') }}"
                                                    type="radio"
                                                    name="question-{{ $question->id }}"
                                                    class="right-answer-btn"
                                                    value={{ $answer->id }}>
                                            @else
                                                <span>{{ $answer->answer }}</span>
                                                <input
                                                    data-question={{ $question->id }}
                                                    data-url="{{ route('answer.right_answer') }}"
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
                            @endif
                        </ul>

                        @lang('lesson.add_answer'):
                        <form action="javascript:void(0)" method="post" class="add-answer-form">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <div class="input-group w-50 mb-3">
                                <input type="text" class="form-control" placeholder="@lang('common.answer')" name="answer" id="answer">
                                <div class="input-group-append">
                                <button class="btn btn-success" type="submit">@lang('lesson.add_answer')</button>
                                </div>
                            </div>
                        </form>

                        @break

                    @case('multiple')
                        <ul style="list-style-type: circle" class="list-answers">
                            @if (count($question->answers))
                                @foreach ($question->answers as $answer)
                                    <li class="clear-fix" id="answer-{{ $answer->id }}">
                                        <div class="float-left">
                                            @if ($answer->status == 1)
                                                <span class="text-success">{{ $answer->answer }}</span>
                                                <input
                                                    checked
                                                    data-question={{ $question->id }}
                                                    data-url="{{ route('answer.right_answer') }}"
                                                    type="checkbox"
                                                    name="question-{{ $question->id }}"
                                                    class="right-answer-btn"
                                                    value={{ $answer->id }}>
                                            @else
                                                <span>{{ $answer->answer }}</span>
                                                <input
                                                    data-question={{ $question->id }}
                                                    data-url="{{ route('answer.right_answer') }}"
                                                    type="checkbox"
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
                            @endif
                        </ul>

                        @lang('lesson.add_answer'):
                        <form action="javascript:void(0)" method="post" class="add-answer-form">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <div class="input-group w-50 mb-3">
                                <input type="text" class="form-control" placeholder="@lang('common.answer')" name="answer" id="answer">
                                <div class="input-group-append">
                                <button class="btn btn-success" type="submit">@lang('lesson.add_answer')</button>
                                </div>
                            </div>
                        </form>
                        
                        @break

                    @case('fillable')
                        @if (count($question->answers->where('status', 1)))
                            <div class="clear-fix" id="answer-{{ $question->answers->where('status', 1)->first()->id }}">
                                <div class="float-left">
                                    @lang('common.answer'): <span>{{ $question->answers->where('status', 1)->first()->answer }}</span>
                                </div>
                                <div class="float-right">
                                    <a id="answer-edit-btn" data-url="{{ route('answer.update', $question->answers->where('status', 1)->first()->id) }}" data-id={{ $question->answers->where('status', 1)->first()->id }}>@lang('common.edit')</a>
                                </div>
                            </div>
                        @else
                            @lang('lesson.add_answer'):
                            <form action="javascript:void(0)" method="post" class="add-answer-form">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}">
                                <input type="hidden" name="status" value=1>
                                <div class="input-group w-50 mb-3">
                                    <input type="text" class="form-control" placeholder="@lang('common.answer')" name="answer" id="answer">
                                    <div class="input-group-append">
                                    <button class="btn btn-success" type="submit">@lang('lesson.add_answer')</button>
                                    </div>
                                </div>
                            </form>
                        @endif

                        @break
                    @default
                        
                @endswitch
            </div>
        </div>
    </div>
@endif