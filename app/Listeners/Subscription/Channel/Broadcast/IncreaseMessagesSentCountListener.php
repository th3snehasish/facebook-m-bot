<?php

namespace App\Listeners\Subscription\Channel\Broadcast;

use App\Events\Subscription\Channel\Broadcast\ScheduleProcessedEvent;
use App\Jobs\Statistics\Projects\IncreaseBroadcastMessageSentCount;
use App\Jobs\Subscription\Channel\IncreaseMessagesSentCount;
use Illuminate\Contracts\Bus\Dispatcher;

class IncreaseMessagesSentCountListener
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * IncreaseProjectMessagesPostedCountListener constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param ScheduleProcessedEvent $event
     */
    public function handle(ScheduleProcessedEvent $event)
    {
        $broadcast = $event->getSchedule()->broadcast;

        if ($broadcast && $broadcast->channel) {
            $this->dispatcher->dispatch(new IncreaseMessagesSentCount($broadcast->channel));

            if ($broadcast->channel->project) {
                $this->dispatcher->dispatch(new IncreaseBroadcastMessageSentCount($broadcast->channel->project));
            }
        }
    }
}
