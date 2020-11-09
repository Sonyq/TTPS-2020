<?php

namespace App\Extensions;

use App\Entity\Internacion;
use App\Entity\InternacionCama;
use Symfony\Component\HttpFoundation\Response;

trait InternacionTrait {

  private function cambiarEstado($internacionId, $estado) {
    $internacion = $this->getDoctrine()->getRepository(Internacion::class)->find($internacionId);

    if (!$internacion) {
      return new Response('La internación id '.$internacionId.' no existe', 400);
    }

    $entityManager = $this->getDoctrine()->getManager();

    $internacionCamaVigente = $this->getDoctrine()->getRepository(InternacionCama::class)->findVigente($internacionId);
    $internacionCamaVigente->setFechaHasta(new \DateTime);
    
    if ($estado == 'obito') {
      $internacion->setFechaObito(new \DateTime);
    } else {
      $internacion->setFechaEgreso(new \DateTime);
    }

    $cama = $internacionCamaVigente->getCama();
    $cama->setEstado("libre");

    $sistema = $cama->getSala()->getSistema();
    $sistema->setCamasDisponibles($sistema->getCamasDisponibles() + 1);
    $sistema->setCamasOcupadas($sistema->getCamasOcupadas() - 1); 

    $entityManager->flush();
        
    return "Se declaró el ".$estado." correctamente";
  }

}