<?php

namespace App\Infrastructure\Repository\Read;

use App\Domain\Repository\RedirectionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Entity\Redirection as DomainRedirection;
use App\Infrastructure\Entity\Redirection as DoctrineRedirection;
use App\Infrastructure\Factory\RedirectionFactory;

class RedirectionReadRepository implements RedirectionRepositoryInterface
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

    public function findByFrom(string $from): ?DomainRedirection
    {
        $doctrineRedirection = $this->entityManager
            ->getRepository(DoctrineRedirection::class)
            ->findOneBy(['from' => $from]);

        if ($doctrineRedirection === null) {
            return null;
        }

        return $this->redirectionFactory->createDomainFromDoctrine($doctrineRedirection);
    }

    public function findAll(): array
    {
        $doctrineRedirections = $this->entityManager
            ->getRepository(DoctrineRedirection::class)
            ->findAll();

        return array_map(
            fn($doctrineRedirection) => $this->redirectionFactory->createDomainFromDoctrine($doctrineRedirection),
            $doctrineRedirections
        );
    }

    public function saveRedirection(DomainRedirection $redirection): DomainRedirection
    {
        throw new \BadMethodCallException("Écriture non supportée ici.");
    }
}
