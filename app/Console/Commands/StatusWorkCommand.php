<?php

namespace App\Console\Commands;

use App\Models\Common\Status\ModelStatus;
use App\Models\Common\Status\StatusTask;
use App\Source\Statuses\Constants\StatusScheduleAction;
use App\Source\Statuses\Contracts\Statusable;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StatusWorkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = StatusTask::getActive();

        $tasks->each(function (StatusTask $task) {
            if ($task->getAction() == StatusScheduleAction::SET) {
                $task->getStatusable()->attachStatus($task->getStatus());
            } else {
                $task->getStatusable()->detachStatus($task->getStatus());
            }

            $task->nextAction();
        });

        return 'Задания журнала статусов выполнены';
    }
}
