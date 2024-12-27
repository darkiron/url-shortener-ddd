<?php

namespace App\Tests\Application\QueryHandler;

use App\Application\Query\RedirectListQuery;
use App\Application\QueryHandler\RedirectListHandler;
use App\Domain\Entity\Redirection;
use App\Domain\Repository\RedirectionRepositoryInterface;
use App\Infrastructure\Locator\RepositoryLocator;
use PHPUnit\Framework\TestCase;

class RedirectListHandlerTest extends TestCase
{
    public function testRedirectListHandlerReturnsListOfRedirections(): void
    {
        // Mock des dépendances
        $repositoryLocatorMock = $this->createMock(RepositoryLocator::class);
        $readRepository = $this->createMock(RedirectionRepositoryInterface::class);
        $repositoryLocatorMock->method('getReadRepository')->willReturn($readRepository);

        // Mock pour simulateur d'une liste non vide de redirections
        $redirections = [
            new Redirection('abc123', 'https://example1.com'),
            new Redirection('def456', 'https://example2.com')
        ];
        $readRepository->method('findAll')->willReturn($redirections);

        // Création du handler à tester
        $handler = new RedirectListHandler($repositoryLocatorMock);

        // Création de la commande
        $query = new RedirectListQuery();

        // Appel du handler
        $result = $handler($query);

        // Assertions
        $this->assertIsArray($result);
        $this->assertCount(2, $result); // Vérifie qu'il retourne bien 2 éléments
        $this->assertSame($redirections, $result); // Vérifie que le résultat retourne bien la liste attendue

        // Vérifie les contenus de la liste
        $this->assertEquals('abc123', $result[0]->getFrom());
        $this->assertEquals('https://example1.com', $result[0]->getTo());
        $this->assertEquals('def456', $result[1]->getFrom());
        $this->assertEquals('https://example2.com', $result[1]->getTo());
    }

    public function testRedirectListHandlerReturnsEmptyList(): void
    {
        // Mock des dépendances
        $repositoryLocatorMock = $this->createMock(RepositoryLocator::class);
        $readRepository = $this->createMock(RedirectionRepositoryInterface::class);
        $repositoryLocatorMock->method('getReadRepository')->willReturn($readRepository);

        // Mock pour simulateur d'une liste vide
        $readRepository->method('findAll')->willReturn([]);

        // Création du handler à tester
        $handler = new RedirectListHandler($repositoryLocatorMock);

        // Création de la commande
        $query = new RedirectListQuery();

        // Appel du handler
        $result = $handler($query);

        // Assertions
        $this->assertIsArray($result);
        $this->assertCount(0, $result); // Vérifie que la liste retournée est vide
    }
}