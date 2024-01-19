<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserActivityLog;

class GenerateActivityReport extends Command
{
    protected $signature = 'activity:report {startDate} {endDate}';
    protected $description = 'Generate a report summarizing user activity';

    public function handle()
    {
        $startDate = $this->argument('startDate');
        $endDate = $this->argument('endDate');

        $logs = \App\Models\UserActivityLog::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        

        $this->info('Activity report generated successfully.');
    }
}
