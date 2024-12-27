<?php

namespace App\Application\CommandHandler;

use AllowDynamicProperties;
use App\Application\Command\CreateRedirectionCommand;
use App\Domain\Entity\Redirection;
use App\Domain\Repository\RedirectionRepositoryInterface;
use App\Infrastructure\Locator\RepositoryLocator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AllowDynamicProperties] #[AsMessageHandler]
class CreateRedirectionHandler
{
    private RedirectionRepositoryInterface $repository;

    public function __construct(
        private readonly RepositoryLocator $repositoryLocator
    ) {
        $this->repository =  $this->repositoryLocator->getWriteRepository();
    }

    public function __invoke(CreateRedirectionCommand $command): string
    {
        $from =  substr(md5($command->originalUrl), 0, 6);
        $redirection = new Redirection($from, $command->originalUrl);

        $redirection = $this->repository->saveRedirection($redirection);

        return $redirection->getFrom();

    }


}