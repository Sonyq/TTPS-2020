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
use App\Entity\Sala;
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
    
    $serializer = $this->get('jms_serializer');
    
    $paciente = $this->getDoctrine()->getRepository(Paciente::class)->find($pf->get('pacienteId'));
    if (!$paciente) {

      $error = [ 
        "message" => "El paciente id '.$pacienteId.' no existe",
      ];

      return new Response($serializer->serialize($error, "json"), 404);
    }

    $sistemaDestino = $this->getDoctrine()->getRepository(Sistema::class)->find($pf->get('sistemaDestinoId'));
    if ($sistemaDestino->getCamasDisponibles() == 0) {

      $error = [ 
        "message" => "No hay camas disponibles en el sistema destino",
      ];

      return new Response($serializer->serialize($error, "json"), 400);
    }

    try {
      
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->getConnection()->beginTransaction();

      $internacionActual = $this->getDoctrine()->getRepository(Internacion::class)->find($pf->get('internacionId'));
  
      //a partir de acá seteo todo lo del sistema destino
      if ($sistemaDestino->getNombre() == 'DOMICILIO') {
  
        //si el destino es domicilio creo una cama nueva para la única sala que hay para DOMICILIO y le pongo estado 'ocupada'.
        //el nro de cama es el uno más del máximo num. q haya.
        $salaDomicilio = $this->getDoctrine()->getRepository(Sala::class)->findBy(['sistema' => $sistemaDestino])[0];

        $cama = new Cama();
        $cama->setSala($salaDomicilio);
        $cama->setEstado('ocupada');
  
        $numeroCama = $this->getDoctrine()->getRepository(Cama::class)->getNroCamaMax($salaDomicilio);

        $cama->setNumero($numeroCama['numero'] + 1);
    
      } else {
  
        //si el destino no es domicilio busco la 1er cama libre que haya y le pongo ocupada.
        //seteo los nros.del sistema destino.
        $cama = $this->getDoctrine()->getRepository(Cama::class)->findPrimerCamaLibre($sistemaDestino->getId());
        $cama->setEstado('ocupada');
        
        $sistemaDestino->setCamasDisponibles($sistemaDestino->getCamasDisponibles() - 1);
        $sistemaDestino->setCamasOcupadas($sistemaDestino->getCamasOcupadas() + 1);
      
      }
  
      //esto es igual para cualquier sistema destino, ya sea Domicilo u otro.
      $internacionCamaNueva = new InternacionCama();
      $internacionCamaNueva->setInternacion($internacionActual);
      $internacionCamaNueva->setCama($cama);

      $entityManager->persist($cama);
      $entityManager->persist($internacionCamaNueva);
      //hasta acá todo lo del sistema destino
  
      //a partir de acá modifico todo lo del sistema Origen
      $sistemaOrigen = $this->getUser()->getSistema();
  
      //si el origen no es domicilio seteo los nros.del sistema.
      if ($sistemaOrigen->getNombre() != 'DOMICILIO') {
  
        $sistemaOrigen->setCamasDisponibles($sistemaOrigen->getCamasDisponibles() + 1);
        $sistemaOrigen->setCamasOcupadas($sistemaOrigen->getCamasOcupadas() - 1);
      
      }
  
      $internacionCamaActual = $this->getDoctrine()->getRepository(InternacionCama::class)
                        ->findBy(["internacion" => $internacionActual, "fecha_hasta" => null])[0];
  
      $internacionCamaActual->setFechaHasta(new \DateTime());
      $internacionCamaActual->getCama()->setEstado('libre');
      //hasta acá todo lo del Origen
  
      $entityManager->flush();
      $entityManager->getConnection()->commit();


    } catch (\Exception $e) {

      $entityManager->getConnection()->rollBack();

      $error = [ 
        "message" => "Se produjo un error al intentar el cambio de sistema",
      ];

      return new Response($serializer->serialize($error, "json"), 500);

    } 

    return new Response($serializer->serialize($internacionCamaActual, "json"), 200);

  }

}
