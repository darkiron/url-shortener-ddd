<?php

namespace App\Controller;

use App\Application\Query\RedirectListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class ApiListController extends AbstractController
{

    /**
     *  old allurlsjson
     */
    #[Route('/api/all', 'api_list_all', priority: 10)]
    public function apiList( MessageBusInterface $bus): JsonResponse
    {
        $command = new RedirectListQuery();

        $envelope = $bus->dispatch($command);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        $redirections = $handledStamp->getResult();

        return $this->json($redirections);

    }

}