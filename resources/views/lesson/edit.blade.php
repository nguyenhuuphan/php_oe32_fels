@extends('layout.master')

@section('title')
    @lang('lesson.edit', ['name' => $lesson->name])
@endsection

@section('content')

<div class="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('lesson.edit', ['name' => $lesson->name])</div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('lesson.update', $lesson->id) }}">
                            {{ csrf_field() }}
                            @method('PATCH')
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('common.name')</label>
                                
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $lesson->name }}" required autocomplete="name" autofocus>
                                    
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">@lang('common.description')</label>
                                
                                <div class="col-md-6">
                                    <textarea
                                        name="description"
                                        id="description"
                                        cols="30"
                                        rows="10"
                                        class="form-control @error('description') is-invalid @enderror"
                                        name="description"
                                        required>{{ $lesson->description }}</textarea>
                                    
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="course-field" class="col-md-4 col-form-label text-md-right">@lang('common.course')</label>
                                
                                <div class="col-md-6">
                                    <select name="course_id" id="course-field" class="form-control @error('course') is-invalid @enderror" required>
                                        @foreach ($courses as $course)
                                            @if ($lesson->id === $course->id || old('course_id') === $course->id)
                                                <option value={{ $course->id }} selected>{{ $course->name }}</option>
                                            @else
                                                <option value={{ $course->id }}>{{ $course->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    
                                    @error('course_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('common.edit')
                                    </button>
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
