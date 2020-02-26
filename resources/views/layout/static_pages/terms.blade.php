@extends('layout.master')

@section('title')
    @lang('common.terms')
@endsection

@section('content')

<div class="course">
    <div class="container">
        <div class="row">
            
            <!-- Course -->
            <div class="col-lg-12">
                
                <div class="course_container">
                    <div class="course_title">@lang('common.terms')</div>
                    
                    <!-- Course Image -->
                    <div class="course_image"><img src="{{ asset('images/terms.jpg')}}" alt=""></div>
                    
                    <!-- Course Tabs -->
                    <div class="course_tabs_container">
                        <div class="tab_panels">
                            <div class="tab_panel active">
                                <div class="tab_panel_title">@lang('common.terms')</div>
                                <div class="tab_panel_content">
                                    <div class="tab_panel_text">
                                        <p>
                                            Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, 
                                            lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. 
                                            Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. 
                                            Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. 
                                            Class aptent taciti sociosquad litora torquent per conubia nostra, per inceptos himenaeos. 
                                            Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. 
                                            Sed non mauris vitae erat consequat auctor eu in elit. 
                                            Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. 
                                            Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. 
                                            Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. 
                                            Lorem Ipsn gravida nibh vel velit auctor aliquet. Class aptent taciti sociosquad 
                                            litora torquent per conubia nostra, per inceptos himenaeos.
                                        </p>
                                    </div>
                                    <div class="tab_panel_section">
                                        <div class="tab_panel_subtitle">Requirements</div>
                                        <ul class="tab_panel_bullets">
                                            <li>Lorem Ipsn gravida nibh vel velit auctor aliquet. Class aptent taciti sociosquad litora torquent.</li>
                                            <li>Cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a.</li>
                                            <li>Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat.</li>
                                            <li>Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</li>
                                        </ul>
                                    </div>
                                    <div class="tab_panel_section">
                                        <div class="tab_panel_subtitle">What is the target audience?</div>
                                        <div class="tab_panel_text">
                                            <p>
                                                This course is intended for anyone interested in learning to master his or her own body.
                                                This course is aimed at beginners, 
                                                so no previous experience with hand balancing skillts is necessary Aenean viverra tincidunt nibh, 
                                                in imperdiet nunc. Suspendisse eu ante pretium, consectetur leo at, congue quam. 
                                                Nullam hendrerit porta ante vitae tristique. 
                                                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="tab_panel_faq">
                                        <div class="tab_panel_title">FAQ</div>
                                        
                                        <!-- Accordions -->
                                        <div class="accordions">
                                            
                                            <div class="elements_accordions">
                                                
                                                <div class="accordion_container">
                                                    <div class="accordion d-flex flex-row align-items-center">
                                                        <div>Can I just enroll in a single course?</div>
                                                    </div>
                                                    <div class="accordion_panel">
                                                        <p>
                                                            Lorem ipsun gravida nibh vel velit auctor aliquet. 
                                                            Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. 
                                                            Duis sed odio sit amet nibh vulputate cursus a.
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="accordion_container">
                                                    <div class="accordion d-flex flex-row align-items-center active">
                                                        <div>I'm not interested in the entire Specialization?</div>
                                                    </div>
                                                    <div class="accordion_panel">
                                                        <p>
                                                            Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, 
                                                            lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. 
                                                            Duis sed odio sit amet nibh vulputate cursus a.
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="accordion_container">
                                                    <div class="accordion d-flex flex-row align-items-center">
                                                        <div>What is the refund policy?</div>
                                                    </div>
                                                    <div class="accordion_panel">
                                                        <p>
                                                            Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, 
                                                            lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. 
                                                            Duis sed odio sit amet nibh vulputate cursus a.
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="accordion_container">
                                                    <div class="accordion d-flex flex-row align-items-center">
                                                        <div>What background knowledge is necessary?</div>
                                                    </div>
                                                    <div class="accordion_panel">
                                                        <p>
                                                            Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, 
                                                            lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. 
                                                            Duis sed odio sit amet nibh vulputate cursus a.
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="accordion_container">
                                                    <div class="accordion d-flex flex-row align-items-center">
                                                        <div>Do i need to take the courses in a specific order?</div>
                                                    </div>
                                                    <div class="accordion_panel">
                                                        <p>
                                                            Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, 
                                                            lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. 
                                                            Duis sed odio sit amet nibh vulputate cursus a.
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
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
