(function(){
    // 后台基础 URI
    var baseURI = baseURI || '/admin/';
    var util = {
        // 生成后台uri
        // example: /admin/user
        makeUri: function(uri){
            return baseURI.endsWith('/') + uri;
        },

        // ajax 请求
        request: function(method, uri, data, done, error){
            var params = {
                url: util.makeUri(uri),
                type: method || 'GET',
                dataType: 'json',
                data: data,
            };

            var done = done || function(){
                console.log('done. ' + params.url);
            };

            var error = error || function(err){
                error('网络错误...');
                console.log("接口调用失败：",err);
            };

            $.ajax(params).done(done).fail(error).always(function() {
                console.log("请求：",params);
            });
        }
    };


    return window.Util = util;
})();