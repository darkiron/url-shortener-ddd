<?php

namespace App\Application\QueryHandler;

use App\Application\Query\RedirectQuery;
use App\Domain\Entity\Redirection;
use App\Domain\Repository\RedirectionRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RedirectHandler
{
    public function __construct(
        private RedirectionRepositoryInterface $repository
    ) {}

    public function __invoke(RedirectQuery $command): Redirection
    {
        $redirection = $this->repository->findByFrom($command->linkId);

        if (!$redirection) {
            throw new \RuntimeException('Lien introuvable.');
        }

        return $redirection;
    }
}
