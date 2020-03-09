@extends('layout.master')

@section('title')
    @lang('user.list_user')
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">

            <!-- Course -->
            <div class="col-lg-12">

                <div class="course_container">
                    <div class="course_title clear-fix">
                        <span class="float-left">@lang('user.list_user')</span>
                        <span class="float-right"><a class="btn btn-info text-white" href="{{ route('user.create') }}">@lang('user.add_user')</a></span>
                    </div>
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('common.email')</th>
                                    <th>@lang('common.course')</th>
                                    <th>@lang('common.role')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ($users ->currentpage()-1) * $users ->perpage() + $loop->index + 1 }}</td>
                                        <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->course['name'] }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <a href="{{ route('user.edit', $user->id) }}">@lang('common.edit')</a>
                                             | 
                                            <a href="{{ route('user.destroy', $user->id) }}">@lang('common.delete')</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">{!! $users->links() !!}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
