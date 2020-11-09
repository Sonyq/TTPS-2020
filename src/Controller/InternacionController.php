<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Paciente;
use App\Entity\Sistema;
use App\Entity\Internacion;
use App\Entity\InternacionCama;
use App\Entity\Cama;
use App\Extensions\InternacionTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class Internación Controller
 *
 * @Route("/api/internacion")
 */
class InternacionController extends FOSRestController
{

  use InternacionTrait; 

  /**
   * @Route("/new", name="internacion_new", methods={"POST"})
   * @SWG\Response(response=200, description="Internación creada exitosamente")
   * @SWG\Tag(name="Internación")
   * @RequestParam(name="pacienteId", strict=true, nullable=false, allowBlank=false, description="Id del paciente")
   * @RequestParam(name="sintomas", strict=true, nullable=false, allowBlank=false, description="Sintomas")
   * @RequestParam(name="fecha_inicio_sintomas", strict=true, nullable=false, allowBlank=false, description="Fecha de inicio de síntomas")
   * @RequestParam(name="fecha_diagnostico", strict=true, nullable=false, allowBlank=false, description="Fecha de diagnóstico de Covid")
   * 
   * @param ParamFetcher $pf
   */
  public function new(Request $request, ParamFetcher $pf): Response
  {
  
    $paciente = $this->getDoctrine()->getRepository(Paciente::class)->find($pf->get('pacienteId'));
    $sistema = $this->getUser()->getSistema();
    if (!$paciente) {
      return new Response('El paciente id '.$pacienteId.' no existe', 400);
    }
    
    if ($sistema->getCamasDisponibles() == 0) {
      return new Response('No hay camas disponibles en el sistema', 400);
    }

    $entityManager = $this->getDoctrine()->getManager();
    
    $internacion= new Internacion();
    $internacion->setPaciente($paciente);
    $internacion->setSintomas($pf->get('sintomas'));
    $internacion->setFechaInicioSintomas(date_create($pf->get('fecha_inicio_sintomas')));
    $internacion->setFechaDiagnostico(date_create($pf->get('fecha_diagnostico')));
    $entityManager->persist($internacion);
    
    $internacionCama = new InternacionCama();

    $camaLibre = $this->getDoctrine()->getRepository(Cama::class)->findPrimerCamaLibre($sistema->getId());
    
    $internacionCama->setInternacion($internacion);
    $internacionCama->setCama($camaLibre);
    $entityManager->persist($internacionCama);

    $camaLibre->setEstado("ocupada");

    $sistema->setCamasDisponibles($sistema->getCamasDisponibles() - 1);
    $sistema->setCamasOcupadas($sistema->getCamasOcupadas() + 1);
    
    $entityManager->flush();

    return new Response('Internación creada', 200);
    
  }

  /**
   * @Route("/ultima", name="internacion_ultima", methods={"GET"})
   * @SWG\Response(response=200, description="Última internación del paciente (vigente o no)")
   * @SWG\Tag(name="Internación")
   * @QueryParam(name="pacienteId", strict=true, nullable=false, allowBlank=false, description="Paciente Id")
   *      
   * @param ParamFetcher $pf
   */
  public function getUltimaInternacion(Request $request, ParamFetcher $pf): Response
  {
    $internacion = $this->getDoctrine()->getRepository(Internacion::class)->findUltimaInternacion($pf->get('pacienteId'));      

    $serializer = $this->get('jms_serializer');    
    
    $result = $internacion ? $serializer->serialize($internacion, "json") : null;
    return new Response($result, 200);
  }

  /**
   * @Route("/egreso", name="internacion_egreso", methods={"GET"})
   * @SWG\Response(response=200, description="Declarar egreso")
   * @SWG\Tag(name="Internación")
   * @QueryParam(name="id", strict=true, nullable=false, allowBlank=false, description="Internación Id")
   *      
   * @param ParamFetcher $pf
   */
  public function declararEgreso(Request $request, ParamFetcher $pf): Response
  {
    $response = $this->cambiarEstado($pf->get('id'), 'egreso');
    return new Response($response, 200);
  }

  /**
   * @Route("/obito", name="internacion_obito", methods={"GET"})
   * @SWG\Response(response=200, description="Declarar obito")
   * @SWG\Tag(name="Internación")
   * @QueryParam(name="id", strict=true, nullable=false, allowBlank=false, description="Internación Id")
   *      
   * @param ParamFetcher $pf
   */
  public function declararObito(Request $request, ParamFetcher $pf): Response
  {
    $response = $this->cambiarEstado($pf->get('id'), 'obito');
    return new Response($response, 200);
  }

}
