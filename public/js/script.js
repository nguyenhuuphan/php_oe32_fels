/* JS Document */

/******************************

[Table of Contents]

1. Vars and Inits
2. Set Header
3. Init Menu
4. Init Header Search
5. Init Home Slider
6. Initialize Milestones


******************************/
$(document).ready(function() {
    "use strict";

    /* 
    
    1. Vars and Inits
    
    */

    var header = $('.header');
    var menuActive = false;
    var menu = $('.menu');
    var burger = $('.hamburger');

    setHeader();

    $(window).on('resize', function() {
        setHeader();
    });

    $(document).on('scroll', function() {
        setHeader();
    });

    initMenu();

    /* 
    
    2. Set Header
    
    */

    function setHeader() {
        if ($(window).scrollTop() > 100) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
    }

    /* 
    
    3. Init Menu
    
    */

    function initMenu() {
        if ($('.menu').length) {
            var menu = $('.menu');
            if ($('.hamburger').length) {
                burger.on('click', function() {
                    if (menuActive) {
                        closeMenu();
                    } else {
                        openMenu();

                        $(document).one('click', function cls(e) {
                            if ($(e.target).hasClass('menu_mm')) {
                                $(document).one('click', cls);
                            } else {
                                closeMenu();
                            }
                        });
                    }
                });
            }
        }
    }

    function openMenu() {
        menu.addClass('active');
        menuActive = true;
    }

    function closeMenu() {
        menu.removeClass('active');
        menuActive = false;
    }

    $(document).on('click', '#logout-btn', function(e) {
        var url = $(this).attr('data');
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.replace(response.url);
                } else {
                    window.location.replace(response.url);
                }
            },
        });
    })

    $(function() {
        $('.word-toggle').change(function(e) {
            var check = $(this).prop('checked');
            var url = $(this).data('url');
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'check': check,
                },
                success: function(response) {
                    //
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })
    })

    $('input.answer-btn').change(function() {
        var target = $(this);
        target.parent().addClass('choose');
        target.parent().parent().find("li:not(.choose)").each(function(){
            $(this).css('text-decoration', 'line-through');
            $(this).find('input').prop('disabled', true);
        });
        var answer_id = target.val();
        var question_id = target.data('question');
        var url = target.data('url');
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'answer_id': answer_id,
                'question_id': question_id,
            },
            success: function(response) {
                if (response.flag) {
                    target.parent().addClass('text-success');
                } else {
                    target.parent().addClass('text-danger');
                    target.parent().parent().find("li input[value="+ response.right_answer +"]").parent().css({
                            'text-decoration': 'none',
                            'color': 'green',
                    });
                }
                var questions_count = $('.progress-bar span.questions').text();
                var percent = (response.answered / questions_count) * 100;
                target.closest('.card').find('a.card-link').addClass('text-info');
                $('.progress-bar span.answers').text(response.answered);
                $('.progress-bar .progress-bar').css({
                    'width': percent + '%',
                });
            },
            error: function(error) {
                console.log('error');
            }
        });
    })

});
