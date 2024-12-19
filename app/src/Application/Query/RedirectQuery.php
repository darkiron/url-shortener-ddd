<?php

namespace App\Application\Query;

class RedirectQuery
{
    public function __construct(
        public readonly string $linkId
    ) {}
}
