<?php

namespace App\Jobs\Statistics\Projects;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncreasePassedRespondCount extends IncreaseJob
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Return statistic key.
     *
     * @return string
     */
    protected function statisticKey()
    {
        return 'pass';
    }
}
