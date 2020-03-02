@extends('layout.master')

@section('title')
@lang('common.home')
@endsection

@section('content')

<!-- Popular Courses -->

<div class="courses">
    <div class="section_background"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section_title_container text-center">
                    <h2 class="section_title">Popular Online Courses</h2>
                    <div class="section_subtitle"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p></div>
                </div>
            </div>
        </div>
        <div class="row courses_row">
            <!-- Course -->
            <div class="col-lg-4 course_col">
                <div class="course">
                    <div class="course_image"><img src="images/course_1.jpg" alt=""></div>
                    <div class="course_body">
                        <h3 class="course_title"><a href="course.html">Software Training</a></h3>
                        <div class="course_text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipi elitsed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="course_footer">
                        <div class="courses_button trans_200"><a href="#">Learn</a></div>
                    </div>
                </div>
            </div>
            
            <!-- Course -->
            <div class="col-lg-4 course_col">
                <div class="course">
                    <div class="course_image"><img src="images/course_2.jpg" alt=""></div>
                    <div class="course_body">
                        <h3 class="course_title"><a href="course.html">Developing Mobile Apps</a></h3>
                        <div class="course_text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipi elitsed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="course_footer">
                        <div class="courses_button trans_200"><a href="#">Learn</a></div>
                    </div>
                </div>
            </div>
            
            <!-- Course -->
            <div class="col-lg-4 course_col">
                <div class="course">
                    <div class="course_image"><img src="images/course_3.jpg" alt=""></div>
                    <div class="course_body">
                        <h3 class="course_title"><a href="course.html">Starting a Startup</a></h3>
                        <div class="course_text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipi elitsed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="course_footer">
                        <div class="courses_button trans_200"><a href="#">Learn</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
