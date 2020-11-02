<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Paciente;
use App\Entity\Sistema;
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

/**
 * Class Paciente Controller
 *
 * @Route("/api/paciente")
 */
class PacienteController extends FOSRestController
{

    /**
     * @Route("/index", name="paciente_index", methods={"GET"})
     * @SWG\Response(response=200, description="Listado de Pacientes")
     * @SWG\Tag(name="Paciente")
     * @QueryParam(name="sistemaId", strict=false, nullable=true, allowBlank=false, description="Sistema Id")
     *      
     * @param ParamFetcher $pf
     */
    public function index(Request $request, ParamFetcher $pf): Response
    {
        //si se recibe un sistemaId como parámetro se utiliza ese, 
        //sinó se utiliza el id del sistema al que pertenece el usuario.
        $sistema = $pf->get('sistemaId') ? $pf->get('sistemaId') : $this->getUser()->getSistema()->getId();
        
        $pacientes = $this->getDoctrine()->getRepository(Paciente::class)->findAllPacientes($sistema);        
        return new JsonResponse($pacientes, 200);
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
     * @RequestParam(name="contacto_nombre", strict=false, description="Nombre de algún contacto")
     * @RequestParam(name="contacto_apellido", strict=false, description="Apellido de algún contacto")
     * @RequestParam(name="contacto_telefono", strict=false, description="Teléfono de algún contacto")
     * @RequestParam(name="contacto_parentesco", strict=false, description="Parentesco del contacto")
     * 
     * @param ParamFetcher $pf
     */
    public function new(Request $request, ParamFetcher $pf): Response
    {
      $entityManager = $this->getDoctrine()->getManager();

      $dni = (int)$pf->get('dni');

      if ($this->getDoctrine()->getRepository(Paciente::class)->findBy(["dni" => $dni])) {
        return new Response('El paciente con dni: '.$dni.' ya se encuentra en el sistema', 400);
      }
      
      $paciente= new Paciente();
      $paciente->setDni($dni);
      $paciente->setApellido($pf->get('apellido'));
      $paciente->setNombre($pf->get('nombre'));
      $paciente->setDireccion($pf->get('direccion'));
      $paciente->setTelefono((int)$pf->get('telefono'));
      $paciente->setEmail($pf->get('email'));
      $paciente->setFechaNacimiento(date_create($pf->get('fecha_nacimiento')));
      $paciente->setObraSocial($pf->get('obra_social'));
      $paciente->setContactoNombre($pf->get('contacto_nombre') ? $pf->get('contacto_nombre') : null);
      $paciente->setContactoApellido($pf->get('contacto_apellido') ? $pf->get('contacto_apellido') : null);
      $paciente->setContactoTelefono($pf->get('contacto_telefono') ? $pf->get('contacto_telefono') : null);
      $paciente->setContactoParentesco($pf->get('contacto_parentesco') ? $pf->get('contacto_parentesco') : null);
      $entityManager->persist($paciente);
      $entityManager->flush();

      return new Response('Paciente agregado', 200);
     
    }

}