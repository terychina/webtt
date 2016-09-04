/**
 * Created by Administrator on 2016/8/31 0031.
 */
$(function() {
    /* Nav */
    $(".nav-damo li").hover(function(){
        $(this).addClass("on-damo");
    },function(){
        $(this).removeClass("on-damo");
    });
    /* accordion */
    $("#evalu_box li").hover(function(){
        $("#evalu_box li").stop();
        $(this).siblings().animate({width:"6.83%"},300);
        if (screen.width >= 1844){
            $(this).animate({width:"36.33%"},300,'easeOutQuart');
        }else  if (screen.width <1844 && screen.width>=980){
            $(this).animate({width:"46.33%"},300,'easeOutQuart');
        }else  if (screen.width<980){
            $(this).animate({width:"66.33%"},300,'easeOutQuart');
        }
    });
    /* banner */
    var bannerSlider = new Slider($('#banner_tabs'), {
        time: 10000,
        delay: 400,
        event: 'hover',
        auto: true,
        mode: 'fade',
        controller: $('#bannerCtrl'),
        activeControllerCls: 'active'
    });
    $('#banner_tabs .flex-prev').click(function() {
        bannerSlider.prev()
    });
    $('#banner_tabs .flex-next').click(function() {
		
        bannerSlider.next()
    });
    $('.caselist li').hover(function(){
        $(this).find("span").show();
    },function(){
        $(this).find("span").hide();
    });
    /* p... */
    $(".news-content").each(function(i){
        var divH = $(this).height();
        var $p = $("p", $(this)).eq(0);
        while ($p.outerHeight() > divH) {
            $p.text($p.text().replace(/(\s)*([a-zA-Z0-9]+|\W)(\.\.\.)?$/, "..."));
        };
    });
	
	/* evaluation star */
	var score;
	var star;
	$(".eva-star").each(function(){
		var score=$(this).find("input[class=score]").val();		
		$(this).find("i").each(function(index){
			if(score>index){
				$(this).attr("class","star_1")
			}else{
				$(this).attr("class","star_3")
			}
		})
	});
	
})