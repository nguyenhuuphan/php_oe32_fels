@extends('layout.master')

@section('title')
    @lang('course.edit', ['name' => $course->name])
@endsection

@section('content')

<div class="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('course.edit', ['name' => $course->name])</div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('course.update', $course->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PATCH')
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('common.name')</label>
                                
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $course->name }}" required autocomplete="name" autofocus>
                                    
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
                                        required>{{ $course->description }}</textarea>
                                    
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">@lang('common.image')</label>
                                
                                <div class="col-md-6">
                                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{ $course->image }}">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <img src="{{ asset('storage/uploads/' . $course->image) }}">

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
