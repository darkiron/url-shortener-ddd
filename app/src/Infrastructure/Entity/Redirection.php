<?php

namespace App\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name:'redirection')]
class Redirection
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(name: 'id', type: "integer")]
    public int $id;

    #[ORM\Column(name: 'uri_from', type: "string", length: 100)]
    public string $from;

    #[ORM\Column(name: 'url_to', type: "string", length: 100)]
    public string $to;
}
