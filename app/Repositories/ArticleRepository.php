<?php
namespace App\Repositories;

use App\Models\Article;
use Session;

/**
 * Article Repository
 */
class ArticleRepository
{
    use BaseRepository;

    /**
     * Article Model
     *
     * @var Article
     */
    protected $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    /**
     * 获取图文列表
     *
     * @param int $pageSize 分页大小
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function lists($pageSize)
    {
        return $this->model->orderBy('id','desc')->paginate($pageSize);
    }

    public function store($input)
    {
        return $this->savePost($this->model,$input);
    }

    public function update($id, $input)
    {
        $model = $this->model->find($id);

        return $this->savePost($model,$input);
    }

    public function savePost($model,$input)
    {
        //var_dump($input);die();

        $model->fill($input);

        $model->save();
    }
}