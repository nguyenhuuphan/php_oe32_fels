@extends('layout.master')

@section('title')
    @lang('course.edit_word', ['name' => $word->name])
@endsection

@section('content')

<div class="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('course.edit_word', ['name' => $word->name])</div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('word.update', $word->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PATCH')
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Word Content" value="{{ $word->name }}">
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="spelling" id="spelling" placeholder="Word Spelling" value="{{ $word->spelling }}">
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="mean" id="mean" placeholder="Word Mean" value="{{ $word->mean }}">
                            </div>
                            <div class="input-group mb-3">
                                <textarea name="def" id="def" class="form-control" placeholder="Word Defination">{{ $word->def }}</textarea>
                            </div>
                            <div class="input-group mb-3">
                                <label for="audio">@lang('common.audio')</label>
                                <input type="file" class="form-control" name="audio" id="audio">
                            </div>
                            @if($word->audio)
                                <audio controls>
                                    <source src="{{ asset('storage/uploads/' . $word->audio) }}" type="audio/mpeg">
                                </audio>
                            @endif
                            <div class="input-group mb-3">
                                <label for="image">@lang('common.image')</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                            @if($word->image)
                                <img src="{{ asset('storage/uploads/' . $word->image) }}">
                            @endif
                            <div class="input-group mb-3">
                                <select name="type" id="type" class="form-control">
                                    @foreach (Helper::getWordTypes() as $item => $key)
                                    @if ($item === $word->type)
                                        <option selected value="{{ $item }}">{{ $key }}</option>
                                    @else
                                        <option value="{{ $item }}">{{ $key }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="submit">@lang('common.edit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
