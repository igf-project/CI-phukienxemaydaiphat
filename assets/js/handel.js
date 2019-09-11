$(document).ready(function() {
    $(".ct-navbar-search-full-width #search").focusin(function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.scrollTo(0, 0);
        $('.ct-back-btn').attr('onclick', '');
        $('.ct-back-btn i').toggleClass('fa-chevron-left');
        $('.ct-back-btn i').toggleClass('fa-times');
        $(".top-search-key").addClass('top-search-key-show');
        $(".hamburger").addClass('hamburger--arrow');
        $(".hamburger").removeClass('hamburger--squeeze');
        $(".hamburger").addClass('is-active');
        $(".hamburger").attr('data-toggle', '');
        $('body').css({
            'height': '100vh',
            'overflow': 'hidden',
            'position': 'fixed'
        });
        $('#navbar').removeClass('in');
        $(document).on('touchmove', function(tm) {
            tm.preventDefault();
        });
    });
    $(".ct-back-btn").click(function() {
        if ($('.ct-back-btn i').hasClass('fa-times')) {
            $('.ct-back-btn i').removeClass('fa-times');
            $('.ct-back-btn i').addClass('fa-chevron-left');
            $('.ct-back-btn').attr('onclick', 'goBack()');
        }
        $('.ct-navbar-search-full-width').hide();
    });
    $(document).click(function(e) {
        if ($('.top-search-key').hasClass('top-search-key-show')) {
            if ($(e.target).closest(".top-search-key-show").length === 0 && e.target.id != 'search') {
                $('html, body').animate({
                    scrollTop: $(".main-content").offset().top
                }, 1);
                $(".hamburger").removeClass('hamburger--arrow');
                $(".hamburger").addClass('hamburger--squeeze');
                $(".hamburger").removeClass('is-active');
                $(".hamburger").attr('data-toggle', 'collapse');
                $('body').css({
                    'height': 'auto',
                    'overflow': 'unset',
                    'position': 'relative'
                });
                $(".top-search-key").removeClass('top-search-key-show');
                $(document).on('touchmove', function(tm) {
                    return true;
                });
            } else {}
        } else {}
    });
    $(".cart-mo").click(function() {
        $("#dropdownCartMo").toggleClass('show-quick-cart');
    });
    $(".hamburger").click(function() {
        if ($('.top-search-key').hasClass('top-search-key-show')) {} else {
            $(this).toggleClass('is-active');
            $('.ct-navbar-active .ct-navbar-search-full-width').toggleClass('ct-navbar-search-at-top');
        }
    });
    $(".ct-search-mini").click(function() {
        $('.ct-search-mini i').toggleClass('fa-times');
        $('.ct-search-mini i').toggleClass('fa-search');
        $('body').toggleClass('not-home-show-search');
    });
    $(window).on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        if (scrollTop <= 0) {
            $('#ct-mobile-navbar').removeClass('ct-navbar-active');
        } else {
            $('#ct-mobile-navbar').addClass('ct-navbar-active');
        }
    });
    var $mainMenu = $('.ct-menu-parent').on('click', 'span.sub-arrow', function(e) {
        var obj = $mainMenu.data('smartmenus');
        if (obj.isCollapsible()) {
            var $item = $(this).parent(),
            $sub = $item.parent().dataSM('sub'),
            subIsVisible = $sub.dataSM('shown-before') && $sub.is(':visible');
            $sub.dataSM('arrowClicked', true);
            obj.itemActivate($item);
            if (subIsVisible) {
                obj.menuHide($sub);
            }
            e.stopPropagation();
            e.preventDefault();
        }
    }).bind({
        'beforeshow.smapi': function(e, menu) {
            var obj = $mainMenu.data('smartmenus');
            if (obj.isCollapsible()) {
                var $menu = $(menu);
                if (!$menu.dataSM('arrowClicked')) {
                    return false;
                }
                $menu.removeDataSM('arrowClicked');
            }
        },
        'show.smapi': function(e, menu) {},
        'hide.smapi': function(e, menu) {}
    });
}); 