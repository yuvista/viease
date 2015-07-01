function Pager($selector, $options){
    var $template = '<div class="viease-pager CLASSES">\
                        <div class="viease-pager-inner">\
                            <a href="#" class="btn viease-pager-btn-prev"><i class="ion-arrow-left-b"></i></a>\
                            <span class="info viease-pager-current-page">CURRENT_PAGE</span><span class="info">/</span><span class="info viease-pager-total-page">TOTAL_PAGE</span>\
                            <a href="#" class="btn viease-pager-btn-next"><i class="ion-arrow-right-b"></i></a>\
                            <input type="number" class="viease-pager-to-page form-control inline-block">\
                            <a href="#" class="btn viease-pager-btn-goto">跳转</a>\
                        </div>\
                    </div>';

    var $pager = {
        option: {
            container: undefined,
            total: 1,
            current:1,
            classes: undefined,
            onChange: function(page){
                console.log(page);
            }
        },

        /**
         * 创建分页器
         *
         * @param {String} $selector
         * @param {Object} $options
         */
        make: function($selector, $options){
            var $container = $($selector);

            $pager.option = $.extend(true, $pager.option, $options);
            $pager.option.container = $selector;

            $pager.render($pager.option);

            $container.find('a').on('click', function(e){
                e.preventDefault();
            });

            // 上一页
            $container.on('click', '.viease-pager-btn-prev', function() {
                var $current = $pager.current();

                if ($current - 1 <= 0){
                    return;
                }

                $pager.option.onChange($current - 1);
                $pager.option.current = $current - 1;
                $pager.render();
            });

            // 下一页
            $container.on('click', '.viease-pager-btn-next', function () {
                var $current = $pager.current();

                if ($current + 1 > $pager.option.total){
                    return;
                }

                $pager.option.onChange($current + 1);
                $pager.option.current = $current + 1;
                $pager.render();
            });

            // 跳转
            $container.on('click', '.viease-pager-btn-goto', function() {
                var $page = parseInt($container.find('.viease-pager-to-page').val()) || $pager.current();

                if ($page > $pager.option.total || $page < 1 || $page  == $pager.current()){
                    return;
                }
                $pager.option.onChange($page);
                $pager.option.current = $page;
                $pager.render();
            });
        },

        /**
         * 获取上一页
         *
         * @return {Int}
         */
        prev: function(){
            var $current = $pager.current();

            return $current - 1 < 0 ? $current : $current - 1;
        },

        /**
         * 获取下一页
         *
         * @return {Int}
         */
        next: function(){
            var $current = $pager.current();

            return $current + 1 > $pager.option.total ? $current : $current + 1;
        },

        /**
         * 获取当前页
         *
         * @param {String} $container
         *
         * @return {Int}
         */
        current: function(){
            return parseInt($($pager.option.container + ' .viease-pager-current-page').text()) || 1;
        },

        render: function(){
            var $option = $pager.option;
            var $container = $($option.container);

            var $new = $template.replace('CURRENT_PAGE', $option.current || 1)
                                .replace('CLASSES', $option.classes)
                                .replace('TOTAL_PAGE', $option.total || 1);

            $container.find('.viease-pager').remove();

            $container.append($new);

            console.log($option);

            if ($option.current == 1){
                $container.find('.viease-pager-btn-prev').hide();
            } else {
                $container.find('.viease-pager-btn-prev').show();
            }

            if ($option.current == $option.total) {
                $container.find('.viease-pager-btn-next').hide();
            } else {
                $container.find('.viease-pager-btn-next').show();
            }

        }
    }

    $pager.make($selector, $options);
}