// 用户相关的js
$(document).on('mouseenter', '.user-item', function(){
    var data = $(this).data();
        data['html'] = true;

    $('#user-popover-template select').val(data.groupId).change().find('[value="'+data.groupId+'"]').attr('selected', true).siblings().attr('selected', false);

    if (!data.content) {
        var groupSelector = $(content).find('select');
        var content = $('#user-popover-template').html();

        for(i in data){
            content = content.replace((new RegExp(i.toUpperCase(), 'g')), data[i]);
        }

        $(this).data('content', content);
    };

    $(this).popover($(this).data());
    $('.popover').popover('hide');
    $(this).popover('show');
});