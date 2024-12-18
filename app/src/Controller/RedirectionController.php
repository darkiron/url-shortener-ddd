<?php

namespace App\Controller;

use App\Application\Query\RedirectQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class RedirectionController extends AbstractController
{
    #[Route('/{linkId}', name: 'redirection')]
    public function Redirection(string $linkId, Request $request, MessageBusInterface $bus): Response
    {
        $queryParameters = $request->getQueryString();
        $command = new RedirectQuery($linkId, $queryParameters);

;

        $envelope = $bus->dispatch($command);

        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        if ($handledStamp) {
            /** @var RedirectResponse $response */
            $response = $handledStamp->getResult();
            return $response;
        } else {
            return $this->render('redirection/show.html.twig', [
            ]);
        }


    }


/**
     * @return \App\Infrastructure\Entity\Redirection[]
     */
    private function findAll(): array
    {
        $connection = (new DatabaseConnectionFactory())->makeFromConfig();
        $repository = new RedirectionRepository($connection);

        return $repository->findAll();
    }
}
