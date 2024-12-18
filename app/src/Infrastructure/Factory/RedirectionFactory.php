<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Redirection as DomainRedirection;
use App\Infrastructure\Entity\Redirection as DoctrineRedirection;

class RedirectionFactory
{
    public function createDomainFromDoctrine(DoctrineRedirection $doctrineRedirection): DomainRedirection
    {
        return new DomainRedirection(
            $doctrineRedirection->from,
            $doctrineRedirection->to
        );
    }

    public function createDoctrineFromDomain(DomainRedirection $domainRedirection): DoctrineRedirection
    {
        $doctrineRedirection = new DoctrineRedirection();
        $doctrineRedirection->from = $domainRedirection->getFrom();
        $doctrineRedirection->to = $domainRedirection->getTo();

        return $doctrineRedirection;
    }
}
