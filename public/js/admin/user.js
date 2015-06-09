// 用户相关的js
$(document).on('mouseenter', '.user-item', function(){
    var data = $(this).data();
        data['html'] = true;

    if (!data.content) {
        var content = $('#user-popover-template').clone().html();

        for(i in data){
            content = content.replace((new RegExp(i, 'g')), data[i]);
        }
        console.log($(content).find('select[name="group"] option[value="'+data.groupId+'"]'));
        $(content).find('select[name="group"] option[value="'+data.groupId+'"]').attr('selected', true).change().siblings().attr('selected', false).parent().change();

        $(this).data('content', content);
    };

    $(this).popover($(this).data());
    $('.popover').popover('hide');
    $(this).popover('show');
});