<?php

namespace Studiow\Domino\EventSourced;

use Studiow\Domino\Event\EventStream;

interface AggregateRootFactory
{
    public function create(string $id, EventStream $history):AggregateRoot;
}
