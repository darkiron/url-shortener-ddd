<?php

namespace App\Application\Command;

class CreateUrlCommand
{
    public function __construct(
        public readonly string $originalUrl
    ) {}
}