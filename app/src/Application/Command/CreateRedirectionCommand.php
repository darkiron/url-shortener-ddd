<?php

namespace App\Application\Command;

class CreateRedirectionCommand
{
    public function __construct(
        public readonly string $originalUrl
    ) {}
}