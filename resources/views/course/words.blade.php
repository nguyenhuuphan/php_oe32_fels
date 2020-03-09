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
                                            <div class="col-4 mb-2" id="word-{{ $word->id }}">
                                                <div class="row">
                                                    <div class="col-6 m-auto word-name">
                                                        {{ $word->name }}
                                                    </div>
                                                    <div class="col-6 word-action">
                                                        <a id="word-edit-btn" data-url="{{ route('word.update', $word->id) }}" data-id={{ $word->id }}>@lang('common.edit')</a>
                                                         | 
                                                        <a id="word-del-btn" data-url="{{ route('word.destroy', $word->id) }}" data-id={{ $word->id }}>@lang('common.delete')</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-12 mt-2 text-center">
                                            <a data-toggle="modal" data-target="#add-word-form">@lang('course.add_word')</a>
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

<div class="modal fade" id="add-word-form">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('course.add_word')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('word.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Word Content">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">@lang('course.add_word')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection