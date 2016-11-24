 $(document).ready(function() {
        var page1H = $('#page1').height(),
            page2H = $('#page2').height(),
            winH = $(window).height();
        $(window).scroll(function() {
            var scrollH = $(window).scrollTop();
            if (page1H + page2H - winH / 2 < scrollH) {
                for (var i = 0; i < 11; i++) {
                    $('.position' + i).animateCss('bounceIn');
                }
            }
        })
    });