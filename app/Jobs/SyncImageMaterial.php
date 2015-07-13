<?php

namespace App\Jobs;

use App\Services\Material as MaterialService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Job;

/**
 * 素材图片素材
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class SyncImageMaterial extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     * 
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle(MaterialService $materialService)
    {
        $materialService->syncRemoteMaterial('image');
        
        $this->delete();
    }
}
