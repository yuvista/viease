/**
 * 实时消息页面
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
define(['jquery', 'repos/message', 'util', 'admin/common'], function ($, Message, Util) {
    var $replyEditor = $('#reply-editor').html();

    $('.media:first').append($replyEditor);
});