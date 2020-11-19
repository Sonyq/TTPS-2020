<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Paciente;
use App\Entity\Sistema;
use App\Entity\Internacion;
use App\Entity\InternacionCama;
use App\Entity\Cama;
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
use JMS\Serializer\SerializationContext;


/**
 * Class Paciente Controller
 *
 * @Route("/api/sistemas")
 */
class SistemasController extends FOSRestController
{

  /**
   * @Route("/index", name="sistemas_index", methods={"GET"})
   * @SWG\Response(response=200, description="Listado de Sistemas")
   * @SWG\Tag(name="Sistemas")
   *      
   * @param ParamFetcher $pf
   */
  public function index(Request $request): Response
  {        
    $serializer = $this->get('jms_serializer');
    $sistemas = $this->getDoctrine()->getRepository(Sistema::class)->findAll();
    return new Response($serializer->serialize($sistemas, "json", SerializationContext::create()->enableMaxDepthChecks()));
  }

  /**
   * @Route("/medicos", name="medicos", methods={"GET"})
   * @SWG\Response(response=200, description="Médicos de un sistema")
   * @SWG\Tag(name="Sistemas")
   * @QueryParam(name="sistema", strict=false, nullable=true, allowBlank=false, description="Sistema Id")
   *      
   * @param ParamFetcher $pf
   */
  public function getMedicosDeUnSistema(Request $request, ParamFetcher $pf): Response
  {        
    $sistemaId = $pf->get('sistema') ? $pf->get('sistema') : $this->getUser()->getSistema()->getId();
    $sistemas = $this->getDoctrine()->getRepository(User::class)->findMedicosDeUnSistema($sistemaId);
    $serializer = $this->get('jms_serializer');
    return new Response($serializer->serialize($sistemas, "json", SerializationContext::create()->enableMaxDepthChecks()));
  }

  /**
   * @Route("/sistemasDestino", name="sistemas_destino", methods={"GET"})
   * @SWG\Response(response=200, description="Sistemas destino de un sistema")
   * @SWG\Tag(name="Sistemas")
   *      
   * @param ParamFetcher $pf
   */
  public function getSistemasDestino(Request $request): Response
  {        
    $serializer = $this->get('jms_serializer');
    $sistemasDestino = $this->getUser()->getSistema()->getSistemasDestino();
    return new Response($serializer->serialize($sistemasDestino, "json", SerializationContext::create()->enableMaxDepthChecks()));
  }

   /**
   * @Route("/cambiar", name="sistema_cambiar", methods={"POST"})
   * @SWG\Response(response=200, description="Cambiar de sistema al paciente")
   * @RequestParam(name="pacienteId", strict=true, nullable=false, allowBlank=false, description="Id del paciente")
   * @RequestParam(name="sistemaDestinoId", strict=true, nullable=false, allowBlank=false, description="Id del sistema destino")
   * @RequestParam(name="internacionId", strict=true, nullable=false, allowBlank=false, description="Id de la internación")
   * @SWG\Tag(name="Sistemas")
   *      
   * @param ParamFetcher $pf
   */
  public function cambiarDeSistema(Request $request, ParamFetcher $pf): Response
  {
    $paciente = $this->getDoctrine()->getRepository(Paciente::class)->find($pf->get('pacienteId'));
    if (!$paciente) {
      return new Response('El paciente id '.$pacienteId.' no existe', 400);
    }

    $sistemaDestino = $this->getDoctrine()->getRepository(Sistema::class)->find($pf->get('sistemaDestinoId'));
    if ($sistemaDestino->getCamasDisponibles() == 0) {
      return new Response('No hay camas disponibles en el sistema destino', 400);
    }

    $entityManager = $this->getDoctrine()->getManager();

    //a partir de acá modifico todo lo del Origen
    $sistemaOrigen = $this->getUser()->getSistema();

    $sistemaOrigen->setCamasDisponibles($sistemaOrigen->getCamasDisponibles() + 1);
    $sistemaOrigen->setCamasOcupadas($sistemaOrigen->getCamasOcupadas() - 1);

    $internacionActual = $this->getDoctrine()->getRepository(Internacion::class)->find($pf->get('internacionId'));

    $internacionCamaActual = $this->getDoctrine()->getRepository(InternacionCama::class)
                    ->findBy(["internacion" => $internacionActual, "fecha_hasta" => null])[0];

    $internacionCamaActual->setFechaHasta(new \DateTime());
    
    $internacionCamaActual->getCama()->setEstado('libre');
    //hasta acá todo lo del Origen

    //a partir de acá seteo todo lo del destino
    $cama = $this->getDoctrine()->getRepository(Cama::class)->findPrimerCamaLibre($sistemaDestino->getId());
    $cama->setEstado('ocupada');
        
    $internacionCamaNueva = new InternacionCama();
    $internacionCamaNueva->setInternacion($internacionActual);
    $internacionCamaNueva->setCama($cama);
    
    $sistemaDestino->setCamasDisponibles($sistemaDestino->getCamasDisponibles() - 1);
    $sistemaDestino->setCamasOcupadas($sistemaDestino->getCamasOcupadas() + 1);
    
    $entityManager->persist($internacionCamaNueva);
    $entityManager->flush();

    $serializer = $this->get('jms_serializer');

    return new Response($serializer->serialize(["msg" => "Se efectuó el cambio de sistema"], "json"), 200);
  }


}
