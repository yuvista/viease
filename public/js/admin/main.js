/**
 * requirejs 入口文件
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
requirejs.config({
    //默认情况下模块所在目录为 /js
    baseUrl: '/js',

    //这里设置的路径是相对与 baseUrl 的，不要包含.js
    paths: {
        // dirs
        admin: 'admin',
        plugins: 'plugins/',
        repos: 'admin/repos/',

        // base modules
        bootstrap:'bootstrap.min',
        jquery: '//cdn.bootcss.com/jquery/2.1.4/jquery.min',
        underscore: 'underscore-min',
        fastclick: 'fastclick.min',
        relocator: 'relocator-1.0.1.min',
        store: 'store+json2.min',
        validator: 'plugins/validator.js/index',
        sweetalert: 'plugins/sweetalert/lib/sweet-alert.min',
        selectpicker: 'plugins/bootstrap-select/dist/js/bootstrap-select.min',
        selectpickerLang: 'plugins/bootstrap-select/dist/js/i18n/defaults-zh_CN',
        magnificPopup: 'plugins/magnific-popup/dist/jquery.magnific-popup.min',
        sweetalertUtil: 'sweetalert.util',
        plupload: 'plugins/plupload/js/plupload.full.min',

        WeChatEditor: 'wechat-editor',

        // tools
        util: 'admin/util',
        pager: 'pager',
        uploader: 'uploader'
    },
    shim: {
        jquery: {
            exports: 'jQuery'
        },
　　　　 underscore:{
            exports: '_'
　　　　 },
        plupload: {
            exports: 'plupload'
        },
        validator: {
            exports: 'Validator',
            deps: ['plugins.validator.js/i18n/zh_CN']
        },
        bootstrap: ['jquery'],
        sweetalertUtil: ['sweetalert'],
        selectpickerLang: ['selectpicker'],
        pager: ['jquery'],
        uploader: ['jquery'],
    },

    // 包导入
    packages: [
        {
            name: 'echarts',
            location: 'plugins/echarts/src',
            main: 'echarts'
        },
        {
            name: 'zrender',
            location: 'plugins/zrender/src',
            main: 'zrender'
        }
    ]
});

define('jquery-private', ['jquery'], function (jq) {
    return jq.noConflict(true);
});

// 基础初始化
require(['admin/common']);