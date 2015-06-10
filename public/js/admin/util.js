(function(){
    // 后台基础 URI
    var baseURI = baseURI || '/admin/';
    var util = {
        // 生成后台uri
        // example: /admin/user
        makeUri: function(uri){
            return baseURI.trim('/') + uri;
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
                error('网络错误...');
                console.log("接口调用失败：",err);
            };

            $('.loading').show();
            $.ajax(params).done(done).fail(err).always(function() {
                console.log("请求：", params);
                $('.loading').hide();
            });
        }
    };


    return window.Util = util;
})();