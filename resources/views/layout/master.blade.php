<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title')</title>
    
    <link rel="stylesheet" href="{{ asset('components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('components/Font-Awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
</head>
<body>
    
    <div class="super_container">
        
        <!-- Header -->
        
        <header class="header">
            
            <!-- Top Bar -->
            <div class="top_bar">
                <div class="top_bar_container">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
                                    <ul class="top_bar_contact_list">
                                        <li><div class="question">@lang('common.top_menu_text')</div></li>
                                        <li>
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <div>001-1234-88888</div>
                                        </li>
                                        <li>
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            <div>info.deercreative@gmail.com</div>
                                        </li>
                                    </ul>
                                    <div class="top_bar_login ml-auto">
                                        @auth
                                            <div class="login_button">
                                                <a href="">@lang('common.dashboard')</a>
                                                | 
                                                <a data="{{ route('logout') }}" id="logout-btn">@lang('auth.logout')</a>
                                            </div>
                                        @else
                                            <div class="login_button">
                                                <a href="{{ route('login') }}">@lang('auth.login')</a>
                                                | 
                                                @if (Route::has('register'))
                                                <a href="{{ route('register') }}">@lang('auth.register')</a>
                                                @endif
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            
            <!-- Header Content -->
            <div class="header_container">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="header_content d-flex flex-row align-items-center justify-content-start">
                                <div class="logo_container">
                                    <a href="{{ route('home') }}">
                                        <div class="logo_text">Unic<span>at</span></div>
                                    </a>
                                </div>
                                <nav class="main_nav_contaner ml-auto">
                                    <ul class="main_nav">
                                        <li class="active"><a href="{{ route('home') }}">@lang('common.home')</a></li>
                                        <li><a href="{{ route('static_pages.about') }}">@lang('common.about')</a></li>
                                        @admin
                                            <li><a href="{{ route('course.create') }}">@lang('course.create')</a>
                                            <li><a href="{{ route('lesson.create') }}">@lang('lesson.create')</a>
                                        @endadmin
                                    </ul>
                                    <div class="hamburger menu_mm">
                                        <i class="fas fa-bars menu_mm" aria-hidden="true"></i>
                                    </div>
                                </nav>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </header>
        
        <!-- Menu -->
        
        <div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
            <div class="menu_close_container"><div class="menu_close"><div></div><div></div></div></div>
            <nav class="menu_nav">
                <ul class="menu_mm">
                    <li class="menu_mm"><a href="{{ route('home') }}">@lang('common.home')</a></li>
                    <li class="menu_mm"><a href="{{ route('static_pages.about') }}">@lang('common.about')</a></li>
                </ul>
            </nav>
        </div>
        
        <div class="content-wrapper">
            @yield('content')
        </div>
        
        <!-- Footer -->
        
        <footer class="footer">
            <div class="footer_background" style="background-image:url({{ asset('images/footer_background.png') }})"></div>
            <div class="container">
                <div class="row footer_row">
                    <div class="col">
                        <div class="footer_content">
                            <div class="row">
                                
                                <div class="col-lg-6 footer_col">
                                    
                                    <!-- Footer About -->
                                    <div class="footer_section footer_about">
                                        <div class="footer_logo_container">
                                            <a href="#">
                                                <div class="footer_logo_text">Unic<span>at</span></div>
                                            </a>
                                        </div>
                                        <div class="footer_about_text">
                                            <p>@lang('common.footer_about_text')</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-lg-6 footer_col">
                                    
                                    <!-- Footer Contact -->
                                    <div class="footer_section footer_contact">
                                        <div class="footer_title">@lang('common.contact_us')</div>
                                        <div class="footer_contact_info">
                                            <ul>
                                                <li>@lang('common.email'): Info.deercreative@gmail.com</li>
                                                <li>@lang('common.phone'):  +(88) 111 555 666</li>
                                                <li>40 Baria Sreet 133/2 New York City, United States</li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row copyright_row">
                    <div class="col">
                        <div class="copyright d-flex flex-lg-row flex-column align-items-center justify-content-start">
                            <div class="cr_text">Copyright &copy; All rights reserved | This template is made with </div>
                            <div class="ml-lg-auto cr_links">
                                <ul class="cr_list">
                                    <li><a href="{{ route('static_pages.terms') }}">@lang('common.terms')</a></li>
                                    <li><a href="{{ route('static_pages.privacy_policy') }}">@lang('common.policy')</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
    </div>
    
    <script src="{{ asset('components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
