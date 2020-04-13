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
                        @if (count($users))
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('common.email')</th>
                                        <th>@lang('common.course')</th>
                                        <th>@lang('user.role')</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ ($users ->currentpage()-1) * $users ->perpage() + $loop->index + 1 }}</td>
                                            <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if (count($user->learningCourse))
                                                    {{ $user->learningCourse->first()->name }}
                                                @endif
                                            </td>
                                            <td>{{ Helper::getUserRole($user->role) }}</td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}">@lang('common.edit')</a>
                                                |     
                                                <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">@lang('common.delete')</button>
                                                </form>
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
                        @else
                            <div class="noti-wrapper">
                                <span class="noti-error">
                                    @lang('user.no_user')
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
