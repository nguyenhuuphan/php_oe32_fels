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
                    <div class="course_title clear-fix">
                        <span class="float-left">@lang('course.words_title', ['course' => $course->name])</span>
                        @admin
                        <span class="float-right"><a data-toggle="modal" data-target="#add-word-form">@lang('course.add_word')</a></span>
                        @endadmin
                    </div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_content">
                                    @if (count($words))
                                        <div class="row list-words">
                                            @foreach ($words as $word)
                                                <div class="col-12 mb-2" id="word-{{ $word->id }}">
                                                    <div class="row">
                                                        <div class="col-9 m-auto word-content">
                                                            <div class="row">
                                                                <div class="col-3 word-image">
                                                                    <img src="{{ asset('storage/uploads/' . $word->image) }}">
                                                                </div>
                                                                <div class="col-9 word-info">
                                                                    <h4 class="word-name">{{ $word->name }}</h4>
                                                                    <p class="m-0 word-spelling">{{ $word->spelling }}</p>
                                                                    <span class="m-0 word-audio">
                                                                        <a class="item-sound main-sound-play" href="javascript:void(0)" sound_url="{{ asset('storage/uploads/' . $word->audio) }}"></a>
                                                                    </span>
                                                                    <p class="m-0 word-mean">{{ $word->mean }}</p>
                                                                    <p class="word-type">{{ Helper::getWordType($word->type) }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3 word-action">
                                                            @admin
                                                            <a href="{{ route('word.edit', $word->id) }}">@lang('common.edit')</a>
                                                            | 
                                                            <a id="word-del-btn" data-url="{{ route('word.destroy', $word->id) }}" data-id={{ $word->id }}>@lang('common.delete')</a>
                                                            @endadmin
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="pagination">
                                                {!! $words->links() !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-center mt-3">
                                                <a class="btn btn-info" href="{{ route('course.learning', $course->id) }}">Start Learning</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="noti-wrapper">
                                            <span class="noti-error">
                                                @lang('course.noti_no_word')
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="course_footer">
                        @auth
                        @if (auth::user()->course['id'] == $course->id)
                        <div class="courses_button trans_200 mt-5"><a href="{{ route('course.lesson', $course->id) }}">@lang('course.lesson')</a></div>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@admin
<div class="modal fade" id="add-word-form">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('course.add_word')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Word Content">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="spelling" id="spelling" placeholder="Word Spelling">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="mean" id="mean" placeholder="Word Mean">
                    </div>
                    <div class="input-group mb-3">
                        <textarea name="def" id="def" class="form-control" placeholder="Word Defination"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <label for="audio">@lang('common.audio')</label>
                        <input type="file" class="form-control" name="audio" id="audio">
                    </div>
                    <div class="input-group mb-3">
                        <label for="image">@lang('common.image')</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="input-group mb-3">
                        <select name="type" id="type" class="form-control">
                            @foreach (Helper::getWordTypes() as $item => $key)
                            <option value="{{ $item }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">@lang('course.add_word')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    if ($("#add-word-form form").length > 0) {
        $("#add-word-form form").on('submit', function(){
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('word.store') }}" ,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function( response ) {
                    if (response.status) {
                        var newWord = response.new;
                        $('.list-words').prepend(
                            '<div class="col-12 mb-2" id="word-' + newWord['id'] + '">'
                                + '<div class="row">'
                                    + '<div class="col-9 m-auto word-content"><div class="row"><div class="col-3 word-image"><img src="' + newWord['image'] + '"></div><div class="col-9 word-info"><h4 class="word-name">' + newWord['name'] + '</h4><p class="m-0 word-spelling">' + newWord['spelling'] + '</p><span class="m-0 word-audio"><a class="item-sound main-sound-play" href="javascript:void(0)" sound_url="' + newWord['audio'] + '"></a></span><p class="m-0 word-mean">' + newWord['mean'] + '</p><p class="word-type">' + newWord['type'] + '</p></div></div></div>'
                                    + '<div class="col-3 word-action">'
                                        + '<a href="' + response.updateUrl + '">' + "@lang('common.edit')" + '</a>'
                                        + ' | '
                                        + '<a id="word-del-btn" data-url="' + response.destroyUrl + '">' + "@lang('common.delete')" + '</a>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        );
                        $('#add-word-form').modal('hide');
                    }
                }
            });
        })
    };

    $('.list-words').on('click', '.word-action #word-del-btn', function() {
        var url = $(this).data('url');
        if (confirm("@lang('common.confirm_msg')")) {
            $.ajax({
                type: "DELETE",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        $('#word-' + response.word_id).remove();
                    }
                },
            });
        }
    });
</script>
@endadmin

@endsection
