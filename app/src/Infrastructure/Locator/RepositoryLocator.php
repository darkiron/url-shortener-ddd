<?php
namespace App\Infrastructure\Locator;

use App\Domain\Repository\RedirectionRepositoryInterface;

class RepositoryLocator
{
public function __construct(
    private RedirectionRepositoryInterface $readRepository,
    private RedirectionRepositoryInterface $writeRepository
) {}

public function getReadRepository(): RedirectionRepositoryInterface
{
return $this->readRepository;
}

public function getWriteRepository(): RedirectionRepositoryInterface
{
return $this->writeRepository;
}
}
