
$(document).ready(function () {

    //初始化bootstrap tools
    $("body").tooltip({
        selector: '[data-toggle="tooltip"]',
        container: "body"
        }),
        $("body").popover({
        selector: '[data-toggle="popover"]',
        container: "body"
    });

    $('select:not(.origin)').selectpicker({
        style: 'btn-transparent',
        size: 4,
    }).on('change', function(){
        $(this).selectpicker({
            style: 'btn-transparent',
            size: 4,
        });
    });

    // 顶部菜单点击切换左侧菜单
    $(document).on('click', '.top-nav > ul.navbar-main > li > a', function (e) {
        var $this = $(e.target);
        var $group = $this.data('group');
        $this.parent().addClass('active').siblings().removeClass('active');
        showMenu($group);
    });

    $('.top-nav > ul > li > a:first').trigger('click');

    // 左侧菜单点击
    $(document).on('click', '#sidebar-nav a', function (e) {
        var $this = $(e.target), $active;
        $this.is('a') || ($this = $this.closest('a'));

        // 折叠同伴
        // $active = $this.parent().siblings(".active");
        // $active && $active.toggleClass('active').find('> ul:visible').slideUp(200);

        if ($this.parent().hasClass('active')) {
            $this.next().slideUp(200);
            $this.find('span i').addClass('ion-ios-arrow-right').removeClass('ion-ios-arrow-down');
        } else {
            $this.next().slideDown(200);
            $this.find('span i').addClass('ion-ios-arrow-down').removeClass('ion-ios-arrow-right');
        }
        $this.parent().toggleClass('active');

        $this.next().is('ul') && e.preventDefault();

        var currentUrl = window.location.origin + window.location.pathname;
    });

    // switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
      var switchery = new Switchery(html, { size: html.getAttribute('data-size') || 'default' });
    });
});

/**
 * 展示左菜单
 */
function showMenu(group) {
    $("#sidebar-nav > ul").hide();
    $(".nav-group-" + group).show();

    $('#sidebar-nav a').each(function(){
        if (window.location.href.indexOf($(this).attr('href')) >= 0) {
            $('#sidebar-nav a').removeClass('active');

            return $(this).addClass('active');
        };
    });
}