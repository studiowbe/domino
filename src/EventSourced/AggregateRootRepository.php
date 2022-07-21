<?php

namespace Studiow\Domino\EventSourced;

use Studiow\Domino\AggregateRootIdNotFoundException;

interface AggregateRootRepository
{
    /**
     * @param string $id
     * @return AggregateRoot
     * @throws AggregateRootIdNotFoundException
     */
    public function fromId(string $id):AggregateRoot;

    public function store(AggregateRoot $aggregateRoot):static;
}
