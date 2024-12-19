<?php

namespace App\Controller;

use App\Application\Query\RedirectQuery;
use App\Domain\Entity\Redirection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

class ResultController extends AbstractController
{

    #[Route('/result/{linkId}', name: 'url_result')]
    public function result(string $linkId, MessageBusInterface $bus): Response
    {
        // Créer la Query pour le bus
        $query = new RedirectQuery($linkId);

        try {
            // Envoyer la Query au bus
            $envelope = $bus->dispatch($query);

            /** @var HandledStamp|null $handledStamp */
            $handledStamp = $envelope->last(HandledStamp::class);

            // Vérifier si la Query a été traitée
            if ($handledStamp) {
                /** @var Redirection $redirection */
                $redirection = $handledStamp->getResult();

            }

        } catch (\Exception $e) {
            throw $this->createNotFoundException('Lien introuvable.');
        }

        return $this->render('result/show.html.twig', ['redirection' => $redirection]);
    }
}