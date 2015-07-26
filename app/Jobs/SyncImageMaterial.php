<?php

namespace App\Jobs;

use App\Services\Material as MaterialService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 图片素材job.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class SyncImageMaterial extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(MaterialService $materialService)
    {
        $materialService->syncRemoteMaterial('image');

        $this->delete();
    }
}
