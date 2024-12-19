<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Redirection;

interface RedirectionRepositoryInterface
{
    public function findByFrom(string $from): ?Redirection;

    /**
     * @return array [Redirection]
     */
    public function findAll(): array;

    public function saveRedirection(Redirection $redirection): Redirection;
}
