<?php

namespace Abramovku\Queuecount\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class QueueCountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:count {list?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Return size of queue by name";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $row = [];
        $count = 0;
        $list = $this->resolveList();

        foreach ($list as $queue) {
            $row[] = [$queue, Queue::size($queue)];
            $count += Queue::size($queue);
        }

        $this->info(trans_choice('queueCount::there', 0, $count));
        $this->table(
            [trans('queueCount::name'), trans('queueCount::jobs')],
            $row
        );
    }

    public function resolveList(): array
    {
        if (!empty($this->argument('list'))) {
            $list = explode(',', $this->argument('list'));

            $list = array_map(
                function($item){
                   return trim($item);
                },
                $list
            );

            return array_values(array_filter(
                $list,
                function($item){
                    return !empty($item);
                }
            ));
        }

        if (!empty(config('queueCount.list')) && is_array(config('queueCount.list'))) {
            return config('queueCount.list');
        }

        return ['default'];
    }
}