<?php

namespace App\Tests\Application\QueryHandler;

use App\Application\Query\RedirectQuery;
use App\Application\QueryHandler\RedirectHandler;
use App\Domain\Entity\Redirection;
use App\Domain\Repository\RedirectionRepositoryInterface;
use App\Infrastructure\Locator\RepositoryLocator;
use PHPUnit\Framework\TestCase;

class RedirectHandlerTest extends TestCase
{
    public function testRedirectHandlerReturnsRedirectionOnValidLinkId(): void
    {
        // Mock des dépendances
        $repositoryLocatorMock = $this->createMock(RepositoryLocator::class);
        $readRepository = $this->createMock(RedirectionRepositoryInterface::class);
        $repositoryLocatorMock->method('getReadRepository')->willReturn($readRepository);

        // Mock de l'entité Redirection
        $redirection = new Redirection('abc123', 'https://example.com');
        $readRepository->method('findByFrom')
            ->with('abc123')
            ->willReturn($redirection);

        // Création du handler à tester
        $handler = new RedirectHandler($repositoryLocatorMock);

        // Création de la commande
        $query = new RedirectQuery('abc123');

        // Appel du handler
        $result = $handler($query);

        // Assertions
        $this->assertSame($redirection, $result);
        $this->assertEquals('abc123', $result->getFrom());
        $this->assertEquals('https://example.com', $result->getTo());
    }

    public function testRedirectHandlerThrowsExceptionOnInvalidLinkId(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Lien introuvable.');

        // Mock des dépendances
        $repositoryLocatorMock = $this->createMock(RepositoryLocator::class);
        $readRepository = $this->createMock(RedirectionRepositoryInterface::class);
        $repositoryLocatorMock->method('getReadRepository')->willReturn($readRepository);

        // Simuler un résultat null pour findByFrom
        $readRepository->method('findByFrom')
            ->with('invalidId')
            ->willReturn(null);

        // Création du handler à tester
        $handler = new RedirectHandler($repositoryLocatorMock);

        // Création de la commande
        $query = new RedirectQuery('invalidId');

        // Appel du handler, devrait lever une exception
        $handler($query);
    }
}