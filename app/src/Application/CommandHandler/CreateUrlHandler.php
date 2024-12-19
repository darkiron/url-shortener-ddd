<?php

namespace App\Application\CommandHandler;

use App\Application\Command\CreateUrlCommand;
use App\Domain\Entity\Redirection;
use App\Domain\Repository\RedirectionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUrlHandler
{
    public function __construct(
        private RedirectionRepositoryInterface $repository
    ) {}

    public function __invoke(CreateUrlCommand $command)
    {
        $from =  substr(md5($command->originalUrl), 0, 6);
        $redirection = new Redirection($from, $command->originalUrl);

        $redirection = $this->repository->saveRedirection($redirection);

        return $redirection->getFrom();

    }


}