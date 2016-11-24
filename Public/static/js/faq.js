$(function() {
        var controller = $("#getAsk");
        $(".getQuestion li").click(function() {
            if ($(this).hasClass('selected')) {
                return;
            }
            var _this=$(this);
            var _id = $(this).find('a').data('faqid');
            // controller.html('<div class="loader"></div>');
            // var path_height=getHeight($(this));
            // controller.html('<div class="loader" style="margin-top:'+path_height+'px"></div>');
            // return;
            setTimeout(function(){
            var path_height=getHeight(_this);
            $.ajax({
                url: 'index.php?s=/Home/faq/faq.html',
                type: 'GET',
                data: {
                    id: _id
                },
                timeout: 15000,
                beforeSend: function() {
                    controller.html('<div class="loader" style="margin-top  :'+path_height+'px"></div>');
                },
                success: function(data) {
                    if (data) {
                        controller.html('<div class="asked_animate" style="margin-top:'+path_height+'px;display:none;"><div><span style="width:16%;padding-left:15px;vertical-align:bottom!important;" class="ask_title disinline-center fw100">问：</span><span class="disinline-center ask_title_content fw100" style="width:84%;font-size:24px;">'+data.question+'</span> </div> <div class="faq_ask_wrap"> <span class="answer f36 fw100">答:</span> <div class="faq_ask fw200">'+data.ask+'</div> <div class="faq_tree"> <img src="Public/static/img/faq_tree.png"> </div> </div> </div>');
                    }
                },
                complete: function() {
                        $(".asked_animate").fadeIn();
                    }
            })
            },500);
        })

        $(".question_wrap").hide();
        $(".faq-question div").click(function() {
            $(this).find('.question_wrap').slideToggle();
            $(this).find('.active-circle').toggleClass('selected_arrow');
            // $(this).siblings('.faq-question').click();
            // var avaHeight = getHeight();
            // $('.faq_total_wrap').height(avaHeight);
        })
        var  babel=true;
        $(".getQuestion li").click(function(e) {
            var _this=$(this);
                // var _offsetTop=_this.offset(),
                //     _navH=$('nav').height(),
                //     _bannerH=$('.container-fluid').height();
                //     // console.log(_navH+_bannerH+60);
                //     var _path=_offsetTop.top-(_navH+_bannerH+60)-75;
                //     $('.asked_animate').css({'margin-top':_path+'px'});
                //     $('.asked_animate').fadeIn();
                //     if(e.pageY){
                //         $('html,body').animate({scrollTop:e.pageY/2},300);
                //     }

            if(babel){
                babel=false;
            }
            else{
                cancelBubble();
            }

            var _siblings = $(this).closest('.faq-question').siblings('.faq-question');
            $(this).addClass('selected').siblings('li').removeClass('selected');
            $(this).closest('.question_wrap').parent('div').siblings('div').find('.question_wrap').slideUp();
            $(this).closest('.question_wrap').parent('div').siblings('div').find('li').removeClass('selected');
            $(this).closest('.question_wrap').parent('div').siblings('div').find('.active-circle').removeClass('selected_arrow');
            $(this).parent().parent().siblings('.question-title').css({
                'color': '#dd915e'
            })
            _siblings.find('.question-title').css({
                'color': ''
            })
            _siblings.find('.question_wrap').slideUp().find('.selected').removeClass('selected');
            _siblings.find('.active-circle').removeClass('selected_arrow');
            if ($(window).width() < 767) {
                _siblings.find('.mobile_ask_wrap').slideUp();
                $(this).siblings('li').find('.mobile_ask_wrap').slideUp();
                $(this).find('.mobile_ask_wrap').slideToggle();
            }
        })

        $(".faq-question .title").click(function() {
            // cancelBubble();
        })

        setTimeout(function() {
            $('.getQuestion li').eq(0).click();
        }, 1500);
        /*reset*/

        function getEvent(){
             if(window.event)    {return window.event;}
             func=getEvent.caller;
             while(func!=null){
                 var arg0=func.arguments[0];
                 if(arg0){
                     if((arg0.constructor==Event || arg0.constructor ==MouseEvent || arg0.constructor==KeyboardEvent) ||(typeof(arg0)=="object" && arg0.preventDefault && arg0.stopPropagation)){
                        return arg0;
                     }
                 }
                 func=func.caller;
             }
             return null;
        }
        function cancelBubble()
        {
            var e=getEvent();
            if(window.event){
                e.cancelBubble=true;
           }else if(e.preventDefault){
                e.stopPropagation();
             }
        }

        function getHeight(obj){
            var _this=obj;
            var _offsetTop=_this.offset(),
                    _navH=$('nav').height(),
                    _bannerH=$('.container-fluid').height();
                    // console.log(_navH+_bannerH+60);
                    var _path=_offsetTop.top-(_navH+_bannerH+60)-75;
                    return _path;
        }
    })