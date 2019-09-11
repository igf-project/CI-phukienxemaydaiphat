$(document).ready(function(){
    $(".hadsub-menu").hover(function(){
        $(this).find(".submenu-lv1").toggleClass("show");
        $(this).find("h2").toggleClass("redColor");
        $(this).toggleClass("borderBt");
    });
    $(".main-menu").hover(function(){
        $(".main_menu_dropdown").toggleClass("show");   
    })   
});

// top panel fixed

$(".main-menu-fixed").html($(".main-menu").html());
$(".search-top-fixed").html($(".search-top").html());
$(".cart-fixed").html($(".cart-top").html());
$(".main-menu-fixed").hover(function(){
    $(this).find($(".main_menu_dropdown_fixed")).toggleClass("show");
});
$(window).scroll(function () {
    try {
        if ($(window).scrollTop() >= $('.main-content').offset().top) {
            $('.menu-scroll-top-mobile').css({position:'fixed',top:'0',left:'0','margin-top': '0','z-index': '9999',width:'100%'});
            $('.top-panel-fixed-wrp').show();
            $(".main-menu-fixed").find($(".main_menu_dropdown")).addClass("main_menu_dropdown_fixed");
            $(".main-menu-fixed").find((".submenu-lv1")).css("margin-right","10px");
        } else {
            $('.menu-scroll-top-mobile').css({position:'static',top:'0',});
            $('.top-panel-fixed-wrp').hide();
            $(".main-menu-fixed").find($(".main_menu_dropdown")).removeClass("main_menu_dropdown_fixed");
            $(".main-menu-fixed").find((".submenu-lv1")).css("margin-right","0");
        }
    } catch (e) {
    }
});
