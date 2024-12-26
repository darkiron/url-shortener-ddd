<?php

namespace App\Application\QueryHandler;

use AllowDynamicProperties;
use App\Application\Query\RedirectListQuery;
use App\Infrastructure\Locator\RepositoryLocator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AllowDynamicProperties] #[AsMessageHandler]
class RedirectListHandler
{
    public function __construct(
        private readonly RepositoryLocator $repositoryLocator
    ) {
        $this->repository =  $this->repositoryLocator->getReadRepository();
    }

    public function __invoke(RedirectListQuery $command): array
    {
        return $this->repository->findAll();
    }
}