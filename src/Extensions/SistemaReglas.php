<?php

namespace App\Extensions;

use App\Entity\Regla;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class SistemaReglas extends ExpressionLanguage 
{

    private $em;

    public function __construct($entityManager)
    {
        parent::__construct();
        $this->em = $entityManager;
    }

    public function evaluar(string $evento, array $datos)
    {
        $reglas = $this->em->getRepository(Regla::class)->findBy(["evento" => $evento]);
        foreach ($reglas as $regla){
            $resultado = $this->evaluate($regla->getExpresion(),$datos);
            //if($resultado){$this->evaluate($regla->getAccion());}
        }
    }



}