(function(){

    var Repo = Repo || {};

    /**
     * 素材仓库
     *
     * @author overtrue <anzhengchao@gmail.com>
     *
     * @type {Object}
     */
    Repo.material = {
        /**
         * 获取素材列表
         *
         * @param {Object}   $request
         * @param {Function} $callback
         */
        getLists: function($request, $callback){
            Util.request('GET', 'material/lists', $request, $callback);
        },

        /**
         * 获取图片素材列表
         *
         * @param {Function} $callback
         */
        getImages: function($callback){
            var $request = {
                type: 'image'
            };

            Repo.material.getLists($request, $callback);
        },

        /**
         * 获取视频素材列表
         *
         * @param {Function} $callback
         */
        getVideos: function($callback){
            var $request = {
                type: 'video'
            };

            Repo.material.getLists($request, $callback);
        },

        /**
         * 获取声音素材列表
         *
         * @param {Function} $callback
         */
        getVoices: function($callback){
            var $request = {
                type: 'voice'
            };

            Repo.material.getLists($request, $callback);
        },

        /**
         * 获取图文素材列表
         *
         * @param {Function} $callback
         */
        getArticles: function($callback){
            var $request = {
                type: 'article'
            };

            Repo.material.getLists($request, $callback);
        },

        /**
         * 删除素材
         *
         * @param {Int}      $id
         * @param {Function} $callback
         */
        delete: function($id, $callback){
            var $request = {
                id: $id
            };

            Util.request('DELETE', 'material/delete', $request, $callback);
        }
    };

    return window.Repo = Repo;

})();