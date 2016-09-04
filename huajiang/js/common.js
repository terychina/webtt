//to Top
var scrolltotop = {
    setting: {
        startline: 100, //起始行
        scrollto: 0, //滚动到指定位置
        scrollduration: 400, //滚动过渡时间
        fadeduration: [500, 100] //淡出淡现消失
    },
    controlHTML: '<img src="images/topback.png" style="width:32px; height:32px; border:0;" />', //返回顶部按钮
    controlattrs: {offsetx: 15, offsety: 15},//返回按钮固定位置
    anchorkeyword: "#top",
    state: {
        isvisible: false,
        shouldvisible: false
    }, scrollup: function () {
        if (!this.cssfixedsupport) {
            this.$control.css({opacity: 0});
        }
        var dest = isNaN(this.setting.scrollto) ? this.setting.scrollto : parseInt(this.setting.scrollto);
        if (typeof dest == "string" && jQuery("#" + dest).length == 1) {
            dest = jQuery("#" + dest).offset().top;
        } else {
            dest = 0;
        }
        this.$body.animate({scrollTop: dest}, this.setting.scrollduration);
        $("#control").hide();
    }, keepfixed: function () {
        var $window = jQuery(window);
        var controlx = $window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx;
        var controly = $window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety;
        this.$control.css({left: controlx + "px", top: controly + "px"});

    }, togglecontrol: function () {
        var scrolltop = jQuery(window).scrollTop();
        if (!this.cssfixedsupport) {
            this.keepfixed();
        }
        this.state.shouldvisible = (scrolltop >= this.setting.startline) ? true : false;
        if (this.state.shouldvisible && !this.state.isvisible) {
            // this.$control.stop().animate({opacity:1},this.setting.fadeduration[0]);
            this.$control.stop().show();
            this.state.isvisible = true;
        } else {
            if (this.state.shouldvisible == false && this.state.isvisible) {
                //  this.$control.stop().animate({opacity:0,},this.setting.fadeduration[1]);
                this.$control.stop().hide();
                this.state.isvisible = false;
            }
        }
    }, init: function () {
        jQuery(document).ready(function ($) {
            var mainobj = scrolltotop;
            var iebrws = document.all;
            mainobj.cssfixedsupport = !iebrws || iebrws && document.compatMode == "CSS1Compat" && window.XMLHttpRequest;
            mainobj.$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $("html") : $("body")) : $("html,body");
            mainobj.$control = $('<div id="topcontrol">' + mainobj.controlHTML + "</div>")
                .css({
                    position: mainobj.cssfixedsupport ? "fixed" : "absolute",
                    bottom: mainobj.controlattrs.offsety,
                    right: mainobj.controlattrs.offsetx,
                    //opacity:1,
                    display: 'none',
                    cursor: "pointer"
                })
                .attr({title: "返回顶部"})
                .click(function () {
                    mainobj.scrollup();
                    return false;
                })
                .appendTo("body");
            if (document.all && !window.XMLHttpRequest && mainobj.$control.text() != "") {
                mainobj.$control.css({
                    width: mainobj.$control.width()
                });
            }
            mainobj.togglecontrol();
            $('a[href="' + mainobj.anchorkeyword + '"]').click(function () {
                mainobj.scrollup();
                return false;
            });
            $(window).bind("scroll resize", function (e) {
                mainobj.togglecontrol();
            });
        });
    }
};
scrolltotop.init();
//to top End

$(document).ready(function () {
    //Nav style
    $('.headerMenuList li a').each(function(){
        if($($(this))[0].href==String(window.location))
            $(this).parent().addClass('on');

    });//Nav style End

    //folwImgIn
    $('.folwImgIn .flowDiv a').each(function(){
        $(this).click(function(event){
            event.preventDefault();
        });
    });
    $("#topcontrol img").hover(function () {
        $(this).stop(true).fadeTo("fast", 0.2);
    }, function () {
        $(this).stop(true).fadeTo("fast", 1);
    });
    $(".headerMenuList li").hover(function () {
        $(this).stop(true).addClass("active");
    }, function () {
        $(this).stop(true).removeClass("active");
    });
    //designer img change
    $(".imgDesignerDiv .coverLayer").hide();
    $(".imgDesignerDiv .descriptLayer").hide();
    $(".imgDesignerDiv").hover(function () {
            $(this).find(".coverLayer").stop(true).fadeTo(500, 0.75);
            $(this).find(".descriptLayer").stop(true).fadeTo(400, 1);
        },
        function () {
            $(this).find(".coverLayer").stop(true).fadeTo(500, 0);
            $(this).find(".descriptLayer").stop(true).fadeTo(400, 0);
        });

    //case img change
    $(".caseImgDiv").hover(function () {
            $(this).find(".caseImg").stop(true).animate({
                width: "340.5px",
                height: "268.5px",
                margin: "-25px 0 0 -25px"
            }, {duration: 400});
        },
        function () {
            $(this).find(".caseImg").stop(true).animate({
                width: '290.5px',
                height: "218.5px",
                margin: "0px"
            }, {duration: 300});

        });
    $(".casePageImgDiv").hover(function () {
            $(this).find(".casePageImg").stop(true).animate({
                width: "448px",
                height: "375px",
                margin: "-25px 0 0 -25px"
            }, {duration: 400});
        },
        function () {
            $(this).find(".casePageImg").stop(true).animate({
                width: '398px',
                height: "325px",
                margin: "0px"
            }, {duration: 300});

        });
    //index news
    $(".newsList li").hover(function () {
            $(this).addClass("newsListLiActive");
            $(this).find("a").css({"color": "#fff"});
        }, function () {
            $(this).removeClass("newsListLiActive");
            $(this).find("a").css({"color": "#666"});
        }
    );

    //news nav
    $(".newsMainNav span").hover(function () {
        $(this).addClass("newsNavActive");
    }, function () {
        $(this).removeClass("newsNavActive")
    });
    $(".caseMoreSpan").hover(function () {
        $(this).find(".caseMoreHoverImg").stop(true).fadeTo("fast", 0);
        $(this).find(".caseMoreJHoverImg").stop(true).fadeTo("fast", 1);
    }, function () {
        $(this).find(".caseMoreHoverImg").stop(true).fadeTo("fast", 1);
        $(this).find(".caseMoreJHoverImg").stop(true).fadeTo("fast", 0);
    });
});
