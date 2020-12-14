<?php

namespace App\Extensions;

use App\Entity\Aviso;

class SistemaAvisos
{

    private $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }



}