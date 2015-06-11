<?php

namespace App\Listeners;

use Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DBQueryListener
{
    /**
     * Handle the event.
     *
     * @param string $sql    查询SQL
     * @param array  $params 参数
     *
     * @return void
     */
    public function handle($sql, $params)
    {
        if (env('APP_ENV', 'production') == 'local') {
            Log::info($sql . ", with[" . join(',', $params) ."]");
        }
    }
}
