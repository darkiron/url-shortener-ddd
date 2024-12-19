<?php

namespace App\Controller;

use App\Application\Query\RedirectQuery;
use App\Domain\Entity\Redirection;
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
        // Récupérer les paramètres de la requête
        $queryParameters = $request->getQueryString();

        // Créer la Query pour le bus
        $query = new RedirectQuery($linkId);

        // Envoyer la Query au bus
        $envelope = $bus->dispatch($query);

        /** @var HandledStamp|null $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        // Vérifier si la Query a été traitée
        if ($handledStamp) {
            /** @var Redirection $redirection */
            $redirection = $handledStamp->getResult();

            // Effectuer la redirection vers l'URL cible
            $targetUrl = $redirection->getTo();

            // Ajouter les paramètres de requête, si disponibles
            if ($queryParameters) {
                $targetUrl .= '?' . $queryParameters;
            }

            return new RedirectResponse($targetUrl);
        }

        // Si aucun résultat n'est disponible, lever une exception
        throw $this->createNotFoundException('Lien introuvable ou redirection impossible.');
    }

}
