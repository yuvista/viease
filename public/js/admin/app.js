showMenu('account');
$('#top-navbar li').click(function(e) {
    $('#top-navbar li').removeClass('active');
    $(this).addClass('active');
    showMenu($(this).find('a').attr("data-module"));
});
/**
     * 左菜单开启样式
     */
$('.second-nav').prev('a').click(function() {
    if ($(this).parent().find('.second-nav').is(':hidden')) {
        $(this).parent().find('.second-nav').show(100);
        $(this).parent().find('.on').removeClass('on');
    } else {
        $(this).parent().find('.second-nav').hide(100);
        $(this).addClass('on');
    }
});

/**
 * 展示左菜单
 */
function showMenu(module) {
    $("#sidebar-nav").find('.list-nav').hide();
    $(".list-nav-" + module).show();
    $('#top-navbar li').each(function() {
        if ($(this).find('a').attr('data-module') == module) {
            $(this).addClass('active');
        }
    });
}