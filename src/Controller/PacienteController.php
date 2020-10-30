<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Paciente;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class Paciente Controller
 *
 * @Route("/api/paciente")
 */
class PacienteController extends AbstractController
{

    /**
     *@Route("/index", name="paciente_index", methods={"GET"})
     * @SWG\Response(response=200, description="Listado de Pacientes")
     * @SWG\Tag(name="Paciente")
     */
    public function index(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $patients = $this->getDoctrine()->getRepository(Paciente::class)->findAll();
        return new Response($serializer->serialize($patients, "json"));
    }

    /**
     * @Route("/new", name="paciente_new", methods={"POST"})
     * @SWG\Response(response=200, description="Paciente creado exitosamente")
     * @SWG\Tag(name="Paciente")
     * @RequestParam(name="dni", strict=true, nullable=false, allowBlank=false, description="Dni")
     * @RequestParam(name="apellido", strict=true, nullable=false, allowBlank=false, description="Apellido")
     * @RequestParam(name="nombre", strict=true, nullable=false, allowBlank=false, description="Nombre")
     * @RequestParam(name="direccion", strict=true, nullable=false, allowBlank=false, description="Dirección")
     * @RequestParam(name="telefono", strict=true, nullable=false, allowBlank=false, description="Teléfono")
     * @RequestParam(name="email", strict=true, nullable=false, allowBlank=false, description="Email")
     * @RequestParam(name="fecha_nacimiento", strict=true, nullable=false, allowBlank=false, description="Fecha de nacimiento.")
     * @RequestParam(name="obra_social", strict=true, nullable=true, allowBlank=true, description="Obra Social")
     * @RequestParam(name="contacto_nombre", description="Nombre de algún contacto")
     * @RequestParam(name="contacto_apellido", description="Apellido de algún contacto")
     * @RequestParam(name="contacto_telefono", description="Teléfono de algún contacto")
     * @RequestParam(name="contacto_parentesco", description="Parentesco del contacto")
     * 
     * @param ParamFetcher $pf
     */
    public function new(Request $request, ParamFetcher $pf): Response
    {
      $entityManager = $this->getDoctrine()->getManager();
      
      $paciente= new Paciente();
      $paciente->setDni((int)$pf->get('dni'));
      $paciente->setApellido($pf->get('apellido'));
      $paciente->setNombre($pf->get('nombre'));
      $paciente->setDireccion($pf->get('direccion'));
      $paciente->setTelefono((int)$pf->get('telefono'));
      $paciente->setEmail($pf->get('email'));
      $paciente->setFechaNacimiento(date_create($pf->get('fecha_nacimiento')));
      $paciente->setObraSocial($pf->get('obra_social'));
      $entityManager->persist($paciente);
      $entityManager->flush();

      return new Response('Paciente agregado', 200);
     
    }

}
