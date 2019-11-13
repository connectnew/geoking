<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Superbalist\PubSub\PubSubAdapterInterface;

class GMB extends Command
{
    /**
     * The name and signature of the subscriber command.
     *
     * @var string
     */
    protected $signature = 'subscriber:name';

    /**
     * The subscriber description.
     *
     * @var string
     */
    protected $description = 'PubSub subscriber for Test';

    /**
     * @var PubSubAdapterInterface
     */
    protected $pubsub;

    /**
     * Create a new command instance.
     *
     * @param PubSubAdapterInterface $pubsub
     */
    public function __construct(PubSubAdapterInterface $pubsub)
    {
        parent::__construct();

        $this->pubsub = $pubsub;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->pubsub->subscribe('my-topic', function ($message) {
            Log::info($message);
        });
    }
}
