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
@endsection
