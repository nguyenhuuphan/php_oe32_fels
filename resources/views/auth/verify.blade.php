@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('auth.verify_email')</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('auth.success_verify')
                        </div>
                    @endif

                    @lang('auth.verify_noti_1')
                    @lang('auth.verify_noti_2'), <a href="{{ route('verification.resend') }}">@lang('auth.verify_noti_link')</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
