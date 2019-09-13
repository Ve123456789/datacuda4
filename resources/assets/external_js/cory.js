$(document).ready(function() {
   
    //======= SLIDER ========//
    $("#testimonial_slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        nav: true,
        autoplay: true,
        mouseDrag: true,
        dots: false,
        navText: ["<img src='/assets/img/Arrow_left.png'>","<img src='/assets/img/Arrow_right.png'>"]
    });

    $(window).scroll(function(){
        if ($(window).scrollTop() >= 50) {
            $('header').addClass('fixed-header');
            $('header').addClass('visible-title');
        }
        else {
            $('header').removeClass('fixed-header');
            $('header').removeClass('visible-title');
        }
    });

    $("#log_in").click(function(){
        $(".log_in").fadeIn();
        $(".main_tag").addClass("main_wrapper_blur");
    });
    $(".m_close_btn").click(function(){
        $(".log_in").fadeOut();
        $(".main_tag").removeClass("main_wrapper_blur");
    });

    
    $("#sign_up").click(function(){
        $(".sign_up").fadeIn();
        $(".main_tag").addClass("main_wrapper_blur");
    });
    $(".m_close_btn").click(function(){
        $(".sign_up").fadeOut();
        $(".main_tag").removeClass("main_wrapper_blur");
    });


    $(".navBtn").click(function(){
        $(".inner_nav").slideDown();
    });

    function flip() {
        $('.card').toggleClass('flipped');
    }

});


