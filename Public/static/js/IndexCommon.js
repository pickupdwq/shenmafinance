function detectZoom (){
          var ratio = 0,
            screen = window.screen,
            ua = navigator.userAgent.toLowerCase();

           if (window.devicePixelRatio !== undefined) {
              ratio = window.devicePixelRatio;
          }
          else if (~ua.indexOf('msie')) {
            if (screen.deviceXDPI && screen.logicalXDPI) {
              ratio = screen.deviceXDPI / screen.logicalXDPI;
            }
          }
          else if (window.outerWidth !== undefined && window.innerWidth !== undefined) {
            ratio = window.outerWidth / window.innerWidth;
          }

           if (ratio){
            ratio = Math.round(ratio * 100);
          }

           return ratio;
        };
        //缩放为110至 125的处理
        var _ratio=detectZoom();
        if(_ratio==110||_ratio==125){
            $(".map_word").css({'width':'73%','padding-top':'3%'});
            $(".map_back").css({'width':'92%','margin-top':'-6%'});
            $(".map_content").css({'padding-top':'0%'})
        }
    $(document).ready(function() {
        var counter=0;
        $("#owl-demo").owlCarousel({
            navigation: false,  //Show next and prev buttons
            slideSpeed: 500,
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            addClassActive:true,
            mouseDrag:false,
            transitionStyle : "fade",
            afterInit:function(){
                if(counter%2==0){
                    $(".owl-wrapper .active img").addClass('banner_outscale')
                }else{
                    // $(".owl-wrapper .active img").addClass('banner_outscale');
                }
                counter++;
            },
            beforeMove:function(){
                if(counter%2==0){
                    $(".owl-wrapper .active img").removeClass('banner_inscale');
                }else{
                    $(".owl-wrapper .active img").removeClass('banner_outscale');
                }
            },
            afterMove:function(){
                if(counter%2==0){
                    $(".owl-wrapper .active img").addClass('banner_outscale');
                }else{
                    $(".owl-wrapper .active img").addClass('banner_inscale');
                }
                counter++;
            }
        });
        if($(window).height()<850){
            $(".map_content").css({'width':'68%','margin':'0 auto'});
            $('.map_total_wrap0').addClass('map_total_wrap0_mac');
            $('.map_total_wrap1').addClass('map_total_wrap1_mac');
            $(".map_total_wrap2").addClass('map_total_wrap2_mac');
            $(".map_total_wrap3").addClass('map_total_wrap3_mac');
            $(".map_total_wrap4").addClass('map_total_wrap4_mac');
        }
            $(window).resize(function(){
                var winH=$(window).height();
                if(winH<850){
                    $(".map_content").css({'width':'68%','margin':'0 auto'});
                    $('.map_total_wrap0').addClass('map_total_wrap0_mac');
                    $('.map_total_wrap1').addClass('map_total_wrap1_mac');
                    $(".map_total_wrap2").addClass('map_total_wrap2_mac');
                    $('.map_total_wrap3').addClass('map_total_wrap3_mac');
                    $(".map_total_wrap4").addClass('map_total_wrap4_mac');
                }
                else{
                    $(".map_content").css({'width':'800px','margin':'0 auto'});
                    $('.map_total_wrap0').removeClass('map_total_wrap0_mac');
                    $('.map_total_wrap1').removeClass('map_total_wrap1_mac');
                    $(".map_total_wrap2").removeClass('map_total_wrap2_mac');
                    $('.map_total_wrap3').removeClass('map_total_wrap3_mac');
                    $(".map_total_wrap4").removeClass('map_total_wrap4_mac');
                }
            })
    

        $('.map_content .vendor').hover(function(){
            $(this).siblings('.avatar-wrap').stop(true,true).fadeIn();
        },
        function(){
            $(this).siblings('.avatar-wrap').stop(true,true).fadeOut();
        })
        $(".owl-item .item").height($(window).height() - $('nav').height());
    })