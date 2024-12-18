<?php

namespace App\Application\Handler;

use App\Application\Query\RedirectQuery;
use App\Domain\Repository\RedirectionRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RedirectHandler
{
    public function __construct(
        private RedirectionRepositoryInterface $repository
    ) {}

    public function __invoke(RedirectQuery $command): RedirectResponse
    {
        $entity = $this->repository->findByFrom($command->linkId);

        if (!$entity) {
            throw new \RuntimeException('Redirection.php not found.');
        }

        $newUrl = $entity->getTo();
        if ($command->queryParameters) {
            $newUrl .= '?' . $command->queryParameters;
        }

        return new RedirectResponse($newUrl);
    }
}
