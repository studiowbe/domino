<?php

namespace Studiow\Domino\EventSourced;

use Studiow\Domino\Event\EventStream;
use Studiow\Domino\Event\RecordedEvent;

abstract class AggregateRootBase implements AggregateRoot
{
    private $recordedEvents = [];

    public function getRecordedEvents(): EventStream
    {
        return  new EventStream($this->recordedEvents);
    }

    public function clearRecordedEvents(): static
    {
        $this->recordedEvents = [];

        return  $this;
    }

    public function event(object $event): static
    {
        $this->recordedEvents[] = RecordedEvent::now($this->getId(), $event);
        $handler = [$this, $this->getEventHandlerMethodName($event)];
        if (is_callable($handler)) {
            call_user_func($handler, $event);
        }

        return  $this;
    }

    protected function getEventHandlerMethodName(object $event):string
    {
        return 'handle'.substr(strrchr(get_class($event), '\\'), 1);
    }
}
