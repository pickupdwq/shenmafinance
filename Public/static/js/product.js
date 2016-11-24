$(document).ready(function() {
        aniF();        
        $(window).resize(function(){
            aniF();
        });

        function aniF(){
        var winW=$(window).width();
        if (winW > 767) {
        var page1H = $('#page1').height(),
            page2H = $('#page2').height(),
            page3H = $('#pgae3').height(),
            winH = $(window).height(),
            documentH = $(document).height();
        $(window).scroll(function() {
            var scrollH = $(document).scrollTop();
            if (page1H - winH / 2 < scrollH) {
                /*想分期买车*/
                $(".img1").animateCss('fadeInLeft');
                $(".img2").animateCss('fadeIn');
                $(".img3").animateCss('fadeIn');
                $(".img4").animateCss('fadeIn');
                $(".img5").animateCss('fadeInUp');
                $(".img6").animateCss('fadeInUp');
                $(".img7").animateCss('fadeInLeft');
            }
            if (page1H + page2H < scrollH) {
                /*信用贷*/
                // $(".product_img1").animateCss('fadeInLeft');
                // $(".product-description").animateCss('fadeInUp');
                // $(".bottom_qrcode").animateCss('fadeIn');
            }
            if (documentH - (page1H + page2H + page3H) < scrollH) {
                /*信用贷办理流程*/
                $('.bottom_img1').animateCss('fadeIn');
                $('.bottom_img11').animateCss('fadeInLeft');
                $('.bottom_img3').animateCss('fadeInUp');
                $('.bottom_img4').animateCss('fadeInUp');
                $('.common_animate').animateCss('kache_move');
                $('.common_animate_sub').animateCss('kache_move_again');
                setTimeout(function(){
                    $('.home-secondblock .bottom_img6').css({'transition':'1s all','bottom':'16%'});
                },5500)
            }
        })
        }
        else{
            for(var i=0;i<6;i++){
                $(".bottom_img"+i).removeClass('opacity0');
            }
        }
        }
    });