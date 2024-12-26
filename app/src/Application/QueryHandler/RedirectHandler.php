<?php

namespace App\Application\QueryHandler;

use AllowDynamicProperties;
use App\Application\Query\RedirectQuery;
use App\Domain\Entity\Redirection;
use App\Infrastructure\Locator\RepositoryLocator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AllowDynamicProperties] #[AsMessageHandler]
class RedirectHandler
{
    public function __construct(
        private readonly RepositoryLocator $repositoryLocator
    ) {
        $this->repository =  $this->repositoryLocator->getReadRepository();
    }

    public function __invoke(RedirectQuery $command): Redirection
    {
        $redirection = $this->repository->findByFrom($command->linkId);

        if (!$redirection) {
            throw new \RuntimeException('Lien introuvable.');
        }

        return $redirection;
    }
}
