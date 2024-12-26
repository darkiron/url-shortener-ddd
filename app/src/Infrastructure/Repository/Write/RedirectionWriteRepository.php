<?php

namespace App\Infrastructure\Repository\Write;

use App\Domain\Repository\RedirectionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Entity\Redirection;
use App\Infrastructure\Factory\RedirectionFactory;

class RedirectionWriteRepository implements RedirectionRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private RedirectionFactory $redirectionFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        RedirectionFactory $redirectionFactory
    ) {
        $this->entityManager = $entityManager;
        $this->redirectionFactory = $redirectionFactory;
    }

    public function findByFrom(string $from): ?Redirection
    {
        throw new \BadMethodCallException("Lecture non supportée ici.");
    }

    public function findAll(): array
    {
        throw new \BadMethodCallException("Lecture non supportée ici.");
    }

    public function saveRedirection(Redirection $redirection): Redirection
    {
        $doctrineRedirection = $this->redirectionFactory->createDoctrineFromDomain($redirection);

        $this->entityManager->persist($doctrineRedirection);
        $this->entityManager->flush();

        return $this->redirectionFactory->createDomainFromDoctrine($doctrineRedirection);
    }


}
