<?php

namespace App\Tests\Application\CommandHandler;

use App\Application\Command\CreateRedirectionCommand;
use App\Application\CommandHandler\CreateRedirectionHandler;
use App\Domain\Entity\Redirection;
use App\Domain\Repository\RedirectionRepositoryInterface;
use App\Infrastructure\Locator\RepositoryLocator;
use PHPUnit\Framework\TestCase;

class CreateRedirectionHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Préparation des mocks
        $repositoryMock = $this->createMock(RedirectionRepositoryInterface::class);
        $repositoryLocatorMock = $this->createMock(RepositoryLocator::class);

        $repositoryLocatorMock
            ->expects($this->once())
            ->method('getWriteRepository')
            ->willReturn($repositoryMock);

        $command = new CreateRedirectionCommand('https://example.com');

        $fromHash = substr(md5($command->originalUrl), 0, 6);
        $redirectionMock = new Redirection($fromHash, $command->originalUrl);

        $repositoryMock
            ->expects($this->once())
            ->method('saveRedirection')
            ->with($this->callback(function (Redirection $redirection) use ($fromHash, $command) {
                return $redirection->getFrom() === $fromHash && $redirection->getTo() === $command->originalUrl;
            }))
            ->willReturn($redirectionMock);

        // Test de la classe
        $handler = new CreateRedirectionHandler($repositoryLocatorMock);
        $result = $handler($command);

        // Assertions
        $this->assertSame($fromHash, $result);
    }
}
