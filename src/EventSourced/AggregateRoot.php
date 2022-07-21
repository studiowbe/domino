<?php

namespace Studiow\Domino\EventSourced;

use Studiow\Domino\Event\EventStream;

interface AggregateRoot
{
    public function getId():string;

    public function getRecordedEvents():EventStream;

    public function clearRecordedEvents():static;

    public function event(object $event):static;
}
