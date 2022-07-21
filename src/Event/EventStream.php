<?php

namespace Studiow\Domino\Event;

class EventStream
{
    private array $events = [];

    public function __construct(array $events = [])
    {
        array_map([$this, 'append'], $events);
    }

    public function append(RecordedEvent $event):static
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * @return RecordedEvent[]
     */
    public function toArray(): array
    {
        return $this->events;
    }
}
