<?php

namespace App\Entity;

use App\Entity\Aviso;

class SistemaReglas
{

    private $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }



}