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
            $request = {
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
            $request = {
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
            $request = {
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
            $request = {
                type: 'article'
            };

            Repo.material.getLists($request, $callback);
        }
    };

    return window.Repo = Repo;

})();