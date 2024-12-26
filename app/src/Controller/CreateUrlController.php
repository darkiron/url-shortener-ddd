<?php

namespace App\Controller;

use App\Application\Command\CreateRedirectionCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

class CreateUrlController extends AbstractController
{

    #[Route('/create-url', name: 'create_url', methods: ['POST'])]
    public function createUrl(Request $request, MessageBusInterface $bus): RedirectResponse
    {
        // Récupérer l'URL d'origine depuis le formulaire
        $originalUrl = $request->request->get('originalUrl');

        // Valider les données
        if (empty($originalUrl) || !filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('L’URL fournie est invalide.');
        }

        // Créer et envoyer la commande au bus
        $command = new CreateRedirectionCommand($originalUrl);

        $envelope = $bus->dispatch($command);

        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        if ($handledStamp) {
            /** @var string $shortUrl */
            $shortUrl = $handledStamp->getResult();

            return $this->redirectToRoute('url_result', ['linkId' => $shortUrl]);
        }

        throw new \RuntimeException('Le raccourcissement de l’URL a échoué.');
    }


}