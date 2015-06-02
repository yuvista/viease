<?php 

namespace App\Services\Html;

/**
 * form 构建类
 */
class FormBuilder extends \Illuminate\Html\FormBuilder {

    /**
     * demo
     *
     * @return void
     */
    public function demo()
    {
        echo '<h1>haha</h1>';
    }
}