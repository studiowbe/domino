<?php

namespace Studiow\Domino\Event;

interface EventHandler
{
    public function handle(RecordedEvent $event);
}
