define(['jquery', 'uploader', 'admin/common'], function ($, Uploader) {
    $(function(){
        var $ue = UE.getEditor('container');

        function checkAddBtn () {
            var $addBtnBox = $('.add-new-item').closest('.article-preview-item');
            if($('.articles-preview-container .article-preview-item').length -1 >= 8){
                $addBtnBox.slideUp(100);
            } else {
                $addBtnBox.slideDown(100);
            }
        }

        // 添加项目
        $('.articles-preview-container').on('click', '.add-new-item', function(){
            var $parentItem = $(this).closest('.article-preview-item');
            $parentItem.before($('#preview-item-template').html());
            checkAddBtn();
        });

        // 删除项目
        $('.articles-preview-container').on('click', '.delete', function(){
            $(this).closest('.article-preview-item').slideUp(200, function(){
                $(this).remove();
                checkAddBtn();
            });
        });
    })
});