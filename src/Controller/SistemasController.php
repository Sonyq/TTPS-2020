<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sistema;
use App\Entity\User;
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

}
