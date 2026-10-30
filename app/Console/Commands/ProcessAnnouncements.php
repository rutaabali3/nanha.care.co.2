<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAnnouncementsJob;
use Illuminate\Console\Command;

class ProcessAnnouncements extends Command
{
    protected $signature = 'nanhacare:process-announcements';

    protected $description = 'Process scheduled announcements';

    public function handle(): void
    {
        ProcessAnnouncementsJob::dispatch();
    }
}
