(function(){
    // 后台基础 URI
    var baseURI = baseURI || '/admin/';
    var util = {
        // 生成后台uri
        // example: /admin/user
        makeUri: function(uri){
            return baseURI.trim('/') + uri;
        },

        // 表单错误
        formError: function($obj, $errors) {
            $obj.find('.has-error').removeClass('has-error');
            _.mapObject($errors, function(msg, field) {
                var formInput = $obj.find('[name='+field+']');
                formInput.siblings('span.help-block').remove();
                formInput.after('<span class="help-block red">'+msg+'</span>');
                formInput.closest('.form-group').addClass('has-error');
            });
        },

        // ajax 请求
        request: function(method, uri, data, done, err){
            console.log(util.makeUri(uri));
            var params = {
                url: util.makeUri(uri),
                type: method || 'GET',
                dataType: 'json',
                data: data,
            };

            var done = done || function(resp){
                console.log('done. ' + params.url);
                console.log(resp);
            };

            var err = err || function(err){
                error('网络错误...', error.statusText);
                console.log("接口调用失败：",err);
            };

            $('.loading').show();
            $.ajax(params).done(done).fail(err).always(function() {
                console.log("请求：", params);
                $('.loading').hide();
            });
        },

        // 获取表单内的值对象
        parseForm: function (form) {
            var formdata = form.serializeArray();

            var data = {};

            _.each(formdata, function (element) {

                var value = _.values(element);

                // Parsing field arrays.
                if (value[0].indexOf('[]') > 0) {
                    var key = value[0].replace('[]', '');

                    if (!data[key])
                        data[key] = [];

                    data[value[0].replace('[]', '')].push(value[1]);
                } else

                // Parsing nested objects.
                if (value[0].indexOf('.') > 0) {

                    var parent = value[0].substring(0, value[0].indexOf("."));
                    var child = value[0].substring(value[0].lastIndexOf(".") + 1);

                    if (!data[parent])
                        data[parent] = {};

                    data[parent][child] = value[1];
                } else {
                    data[value[0]] = value[1];
                }
            });

            return data;
        },
    };


    return window.Util = util;
})();