$(function(){
    var counter=0;
        $("#owl-demo-mobile").owlCarousel({
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
         function reset_car(){
        $("#buy_car ol li").eq(0).click();
        $("#mobile_purchase ol li").eq(0).click();
        stop();
    }
    function buy_car(){
        $('#buy_buy a').click();
        $("#buy_car ol li").eq(0).click();
        tt=setTimeout(function(){
            $("#buy_car ol li").eq(1).click();
        }, 2000);
        tt=setTimeout(function(){
            $("#buy_car ol li").eq(2).click();
        }, 4000 );
        tt=setTimeout(function(){
            $("#buy_car ol li").eq(3).click();        
        }, 6000);
        tt=setTimeout(function(){
         mobile_purchase()   
        },8000);
    }

    function mobile_purchase(){
        $('#purchase_purchase a').click();
        $("#mobile_purchase ol li").eq(0).click();
        tt=setTimeout(function(){
            $("#mobile_purchase ol li").eq(1).click();
        }, 2000);
        tt=setTimeout(function(){
            $("#mobile_purchase ol li").eq(2).click();
        }, 4000 );
        tt=setTimeout(function(){
            $("#mobile_purchase ol li").eq(3).click();
        }, 6000);
        setTimeout(function(){
            buy_car();
         }, 8000);
    }

    $('#buy_buy a').click(function(){
        $("#buy_car ol li").eq(0).click();
    })
    $('#purchase_purchase a').click(function(){
        $("#mobile_purchase ol li").eq(0).click();
    });
    
    function stop(){
        if(typeof(tt)=='undefined'){
            tt=null;
        }
        console.log(tt);
        clearTimeout(tt); 
    }

    $("#buy_buy,#purchase_purchase").bind('touchstart',function(){
        console.log(tt);
        stop();
    })
    $('#mobile_purchase li,#mobile_buycar li').bind('touchstart',function(){
        stop();
    })
    buy_car();
})