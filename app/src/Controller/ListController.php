<?php

namespace App\Controller;

use App\Application\Query\RedirectListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{

    #[Route('/all', 'list_all', priority: 10)]
    public function list(MessageBusInterface $bus): Response
    {

        $command = new RedirectListQuery();

        $envelope = $bus->dispatch($command);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        $redirections = $handledStamp->getResult();

        return $this->render('redirection/list.html.twig', [
            'redirections' => $redirections,
        ]);
    }
}