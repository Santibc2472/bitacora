jQuery(document).ready(function($) {

    /** Variables from Customizer for testimonial settings */
    var testimonial_control, slider_loop, rtl, animation;
    
    if (restaurant_and_cafe_data.pager == '1') {
        testimonial_control = true;
    } else {
        testimonial_control = false;
    }

    if (restaurant_and_cafe_data.loop == '1') {
        slider_loop = true;
    } else {
        slider_loop = false;
    }

    if (restaurant_and_cafe_data.rtl == '1') {
        rtl = true;
    } else {
        rtl = false;
    }

    if (restaurant_and_cafe_data.animation == 'slide') {
        animation = false;
    } else {
        animation = true;
    }
    $('#testimonial-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: testimonial_control,
        fade: animation,
        asNavFor: '#testimonial-slider-nav',
        autoplaySpeed: restaurant_and_cafe_data.speed, //ms'
        autoplay: restaurant_and_cafe_data.auto,
        infinite: slider_loop,
        rtl: rtl,
        draggable: false,
    });
    $('#testimonial-slider-nav').slick({
        slidesToShow: 7,
        slidesToScroll: 1,
        asNavFor: '#testimonial-slider',
        dots: false,
        arrows: false,
        focusOnSelect: true,
        draggable: false,
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                }
            }
        ],
    });


    // scrolling down
    $(".btn-scroll-down > button").click(function() {
        $('html, body').animate({
            scrollTop: $("#next_section").offset().top
        }, 1000);
    });

    $('.tabs button').click(function() {
        id = $(this).attr('id').split('-').pop();
        $('.tab-content').hide();
        $('#content-' + id).show();
        $('.tabs button').removeClass('active');
        $(this).addClass('active');
        //console.log(id); 
    });

    //mobile-menu
    var winWidth = $(window).width();

    if (winWidth < 1025) {
        $('#menu-opener').click(function() {
            $('body').addClass('menu-open');

            $('.btn-close-menu').click(function() {
                $('body').removeClass('menu-open');
            });
        });

        $('.overlay').click(function() {
            $('body').removeClass('menu-open');
        });

        $('.main-navigation').prepend('<div class="btn-close-menu"></div>');

        $('.main-navigation ul .menu-item-has-children').append('<div class="angle-down"></div>');

        $('.main-navigation ul li .angle-down').click(function() {
            $(this).prev().slideToggle();
            $(this).toggleClass('active');
        });
    }

    if (winWidth > 1024){
        $("#site-navigation ul li a").focus(function() {
            $(this).parents("li").addClass("focus");
        }).blur(function() {
            $(this).parents("li").removeClass("focus");
        });
    }

});
