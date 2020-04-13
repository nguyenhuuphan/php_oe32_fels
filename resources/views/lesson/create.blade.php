@extends('layout.master')

@section('title')
    @lang('lesson.create')
@endsection

@section('content')

<div class="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('lesson.create')</div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('lesson.store') }}">
                            {{ csrf_field() }}
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('common.name')</label>
                                
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    
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
                                        required>{{ old('description') }}</textarea>
                                    
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
                                    <select name="course_id" id="course-field" class="form-control @error('course') is-invalid @enderror" required value={{ old('course') }}>
                                        @foreach ($courses as $course)
                                            <option value={{ $course->id }}>{{ $course->name }}</option>
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
                                        @lang('common.create')
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
