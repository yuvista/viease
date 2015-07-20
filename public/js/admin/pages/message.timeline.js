/**
 * 实时消息页面
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
define(['jquery', 'repos/message', 'WeChatEditor', 'util', 'admin/common'], function ($, Message, WeChatEditor, Util) {
    var $replyEditor = $('#reply-editor').html();

    $('.media:first').append($replyEditor);

    new WeChatEditor($('.editor-wrapper'));
});