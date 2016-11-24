    $(document).ready(function() {

        var winW = $(window).width();
        var owl_invest = $("#owl-invest");


        owl_invest.owlCarousel({
            transitionStyle: "fadeUp",
            items: 4, //10 items above 1000px browser width
            itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
            navigation: false, // Show next and prev buttons
            slideSpeed: 300,
            paginationSpeed: 400,
            // autoPlay: 5000,
            autoHeight:true,
        });

        $("#owl-demo").owlCarousel({
                navigation: false, // Show next and prev buttons
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true,
                autoHeight:true
            });

        $("#owl-finance").owlCarousel({
            navigation: false, // Show next and prev buttons
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
        });


        $("#owl-media").owlCarousel({
            navigation: false, // Show next and prev buttons
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
        });


        $('#dates li').click(function() {
            $("#dates li").removeClass('selected_style');
            judgeClick();
        })


        $('#time_next,#time_prev').bind('click', function() {
            setTimeout(judgeClick, 100);
        })

        function judgeClick() {
            $('.selected').parent('li').addClass('selected_style');
            $('.selected').parent('li').siblings('li').removeClass('selected_style');
        }

        setTimeout(judgeClick, 100);


        /*window resize function */
        $(window).resize(function(){
                 $("#owl-team").owlCarousel({
                navigation: false, // Show next and prev buttons
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true,
                autoHeight:true
                });

                $("#timeline").timelinr({
                autoPlayDirection: 'forward',
                startAt: 4,
                prevButton: '#time_prev',
                // value: any HTML tag or #id, default to #prev
                nextButton: '#time_next',
                // value: any HTML tag or #id, default to #next
                });
                aniamteRest();
        });

        if (winW > 767) {
            $('.mobile_version').hide();
            setTimeout(function() {
                $('.banner_top').addClass('trans-scale');
            }, 500);
        }
        else{
            $('.scroll_top').on('click',function(){
                $('html,body').animate({scrollTop:'0px'},800);
            })
            $('.pc_version').hide();
            $("#mobile-owl-demo").owlCarousel({
                transitionStyle: "fadeUp",
                items: 4, //10 items above 1000px browser width
                itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
                navigation: false, // Show next and prev buttons
                slideSpeed: 300,
                paginationSpeed: 400,
                // autoPlay: 5000,
            });
            $(window).scroll(function(event) {
                var scrollH=$(document).scrollTop();
                if($('.m_finance_banner').height()<scrollH){
                    $(".scroll_top").animateCss('fadeInUp');
                }
                else{
                    $('.scroll_top').removeClass('animated fadeInUp');
                }
            });
        }
         function aniamteRest(){
        $('.tree,.mountain').css({
            width: $('body').width() + 'px'
        });
        setTimeout(function(){
            $('.animation_wrap').height($('.mountain').height());
        },400);
         $('.animation_wrap').height($('.mountain').height());
        $('.road_line_wrap').css({
            width: $('body').width() + 'px',
            height: 130 + 'px'
        });
        }

         /*timelinr*/
         $("#timeline").timelinr({
                autoPlayDirection: 'forward',
                startAt: 4,
                prevButton: '#time_prev',
                // value: any HTML tag or #id, default to #prev
                nextButton: '#time_next',
                // value: any HTML tag or #id, default to #next
                });
    });