$(document).ready(function () {

    showMenu('public');
    $('.navbar-nav li').click(function (e) {
        $('.navbar-nav li').removeClass('active');
        $(this).addClass('active');
        showMenu($(this).find('a').attr("data-module"));
    });
    /**
     * 左菜单开启样式
     */
    $('.second-nav').prev('a').click(function () {
        if ($(this).hasClass('on')) {
            $(this).parent().find('.second-nav').slideUp(100);
            $(this).parent().find('.on').removeClass('on');
        }else{
            $('.ListNav').find('.on').removeClass('on');
            $(this).parent().find('.second-nav').slideDown(100);
            $(this).addClass('on');
        }
    });
});

/**
 * 展示左菜单
 */
function showMenu(module) {
    $("#sidebar-nav").find('.list-nav').hide();
    $(".list-nav-" + module).show();
    //$(".list-nav-" + module).find('.second-nav').hide();
}