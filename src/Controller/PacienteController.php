<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Paciente;
use App\Entity\UserPaciente;
use App\Entity\User;
use App\Entity\Sistema;
use App\Entity\Internacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
     * @QueryParam(name="sistema", strict=false, nullable=true, allowBlank=false, description="Sistema Id")
     *      
     * @param ParamFetcher $pf
     */
    public function index(Request $request, ParamFetcher $pf): Response
    {
        //si se recibe un sistemaId como parámetro se utiliza ese, 
        //sinó se utiliza el id del sistema al que pertenece el usuario.
        $sistema = $pf->get('sistema') ? $pf->get('sistema') : $this->getUser()->getSistema()->getId();
        
        $pacientes = $this->getDoctrine()->getRepository(Paciente::class)->findAllPacientes($sistema);        
        return new JsonResponse($pacientes, 200);
    }

    /**
     * @Route("/getPaciente", name="paciente_show", methods={"GET"})
     * @SWG\Response(response=200, description="Paciente")
     * @SWG\Tag(name="Paciente")
     * @QueryParam(name="id", strict=true, nullable=false, allowBlank=false, description="Paciente Id")
     *      
     * @param ParamFetcher $pf
     */
    public function getPaciente(Request $request, ParamFetcher $pf): Response
    {
      // return new Response("todo mal", 400);
      // throw new BadRequestHttpException('message cannot be empty');
      
      $paciente = $this->getDoctrine()->getRepository(Paciente::class)->findPaciente($pf->get('id'));
      $serializer = $this->get('jms_serializer'); 
      return new Response($serializer->serialize($paciente, "json"), 200);
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
     * @RequestParam(name="antecedentes", strict=true, nullable=true, allowBlank=true, description="Antecedentes")
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
      
      $paciente= new Paciente($dni,
                              $pf->get('apellido'),
                              $pf->get('nombre'),
                              $pf->get('direccion'),
                              $pf->get('telefono'),
                              $pf->get('email'),
                              date_create($pf->get('fecha_nacimiento')),
                              $pf->get('obra_social'),
                              $pf->get('antecedentes'),
                              $pf->get('contacto_nombre') ? $pf->get('contacto_nombre') : null,
                              $pf->get('contacto_apellido') ? $pf->get('contacto_apellido') : null,
                              $pf->get('contacto_telefono') ? $pf->get('contacto_telefono') : null,
                              $pf->get('contacto_parentesco') ? $pf->get('contacto_parentesco') : null);
      
      $entityManager->persist($paciente);
      $entityManager->flush();

      return new Response('Paciente agregado', 200);
     
    }

    /**
     * @Route("/asignarMedico", name="asignar_medico", methods={"POST"})
     * @SWG\Response(response=200, description="Asignar médico a paciente")
     * @SWG\Tag(name="Paciente")
     * @RequestParam(name="pacienteId", strict=true, nullable=false, allowBlank=false, description="Paciente Id")
     * @RequestParam(name="medicoId", strict=true, nullable=false, allowBlank=false, description="Médico Id")
     * 
     * @param ParamFetcher $pf
     */
    public function asignarMedico(Request $request, ParamFetcher $pf): Response
    {
      $entityManager = $this->getDoctrine()->getManager();

      $pacienteId = $pf->get('pacienteId');
      $medicoId = $pf->get('medicoId');

      $paciente = $this->getDoctrine()->getRepository(Paciente::class)->find($pacienteId);
      $medico = $this->getDoctrine()->getRepository(User::class)->find($medicoId);

      $yaExisteLaRelacion = $this->getDoctrine()->getRepository(UserPaciente::class)->findBy(['user' => $medico, 
                                                                                              'paciente' => $paciente,
                                                                                              'fecha_hasta' => null]);
      
      if ($yaExisteLaRelacion) {
        return new Response('Ese médico ya se encuentra asignado al paciente', 200);
      }

      $userPaciente= new UserPaciente($paciente, $medico);
      
      $entityManager->persist($userPaciente);
      $entityManager->flush();

      return new Response('Médico asignado', 200);
     
    }

}
