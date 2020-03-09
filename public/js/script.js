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
                    window.location.href = '/login';
                }
            },
        });
    });

    $('.card').on('click', '#question-del-btn', function() {
        var url = $(this).data('url');
        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    $('#question-' + response.question_id).remove();
                }
            },
        });
    });

    $('.card').on('click', '#question-edit-btn', function() {
        var old_html = $(this).parent().parent().find('.card-link-wrapper').html();
        var val = $(this).parent().parent().find('.card-link span').text();
        var url = $(this).data('url');
        $(this).parent().parent().find('.card-link-wrapper').html("<input id='question-update' class='form-control' name='question' type='text' value='" + val + "'>");
        $('#question-update').focusout(function(){
            var question = $(this).val();
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    question: question
                },
                success: function(response) {
                    if (response.status) {
                        $('#question-update').parent().html(old_html).find('.card-link span').text(question);
                    }
                },
            });
        })
    });

    $('.add-answer-form-btn').click(function() {
        $('#add-answer-form form input[name="question_id"]').val($(this).data('id'));
    })

    $('.card').on('click', '#answer-del-btn', function() {
        var url = $(this).data('url');
        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    $('#answer-' + response.answer_id).remove();
                }
            },
        });
    });
    
    $('.card').on('click', '#answer-edit-btn', function() {
        var old_html = $(this).parent().parent().find('.float-left').html();
        var val = $(this).parent().parent().find('.float-left span').text();
        var url = $(this).data('url');
        $(this).parent().parent().find('.float-left').html("<input id='answer-update' class='form-control' name='answer' type='text' value='" + val + "'>");
        $('#answer-update').focusout(function(){
            var answer = $(this).val();
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    answer: answer
                },
                success: function(response) {
                    if (response.status) {
                        $('#answer-update').parent().html(old_html).find('span').text(answer);
                    }
                },
            });
        })
    });

    $('input.right-answer-btn').change(function() {
        var target = $(this);
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
                if (response.status) {
                    target.parent().parent().parent().find('span.text-success').each(function() {
                        $(this).removeClass('text-success');
                    });
                    target.parent().find('span').addClass('text-success');
                }
            },
            error: function(error) {
                console.log('error');
            }
        });
    });

    $('.word-action').on('click', '#word-del-btn', function() {
        var url = $(this).data('url');
        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    $('#word-' + response.word_id).remove();
                }
            },
        });
    });
    
    $('.word-action').on('click', '#word-edit-btn', function() {
        var val = ($(this).parent().parent().find('.word-name').text()).trim();
        var url = $(this).data('url');
        $(this).parent().parent().find('.word-name').html("<input id='word-update' class='form-control' name='word' type='text' value='" + val + "'>");
        $('#word-update').focusout(function(){
            var word = $(this).val();
            $.ajax({
                type: "PATCH",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    word: word
                },
                success: function(response) {
                    if (response.status) {
                        $('#word-update').parent().html(word);
                    }
                },
            });
        })
    });
});
