<?php

namespace App\Observers;

use App\Services\Material as MaterialService;
use App\Models\Material;

/**
 * Material模型观察者.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class MaterialObserver
{
    /**
     * 素材服务
     *
     * @var App\Services\Material
     */
    private $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    public function saving(Material $material)
    {
        $material->media_id = $this->materialService->buildMaterialMediaId();
    }

    public function created(Material $material)
    {
        if ($material->type != 'article') {
            $material->original_id = $this->materialService->updateToRemote($material);
        }
    }
}
