<?php

namespace App\Application\Handler;

use App\Application\Query\RedirectListQuery;
use App\Domain\Repository\RedirectionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RedirectListHandler
{
    public function __construct(
        private RedirectionRepositoryInterface $repository
    ) {}

    public function __invoke(RedirectListQuery $command): array
    {
        return $this->repository->findAll();
    }
}