@extends('layout.master')

@section('title')
    @lang('common.result')
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">
            
            <!-- Course -->
            <div class="col-lg-12">
                
                <div class="course_container">
                    <div class="course_title">@lang('common.result')</div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_content">
                                    <table>
                                        <tr>
                                            <th>@lang('common.name'): </th>
                                            <td>{{ auth::user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('common.course'): </th>
                                            <td>{{ $course->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('common.lesson'): </th>
                                            <td>{{ $course->lesson()->first()->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('common.result'): </th>
                                            <td>{{ $result }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
