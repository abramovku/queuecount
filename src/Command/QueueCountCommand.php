<?php

namespace Abramovku\Queuecount\Command;

use Illuminate\Console\Command;

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
    protected $description = 'Return size of queue by name';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $row = [];
        $list = $this->resolveList();

        foreach ($list as $queue) {
            $row[$queue] = Queue::size($queue);
        }

        $this->table(
            ['Name', 'Jobs'],
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