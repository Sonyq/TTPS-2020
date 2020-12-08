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
use Symfony\Component\Mime\Message;

/**
 * Class Paciente Controller
 *
 * @Route("/api/paciente")
 */
class PacienteController extends FOSRestController
{

    /**
     * @Route("/internados", name="pacientes_internados", methods={"GET"})
     * @SWG\Response(response=200, description="Listado de pacientes internados")
     * @SWG\Tag(name="Paciente")
     * @QueryParam(name="sistema", strict=false, nullable=true, allowBlank=false, description="Sistema Id")
     *      
     * @param ParamFetcher $pf
     */
    public function getPacientesInternados(Request $request, ParamFetcher $pf): Response
    {
        //si se recibe un sistemaId como parámetro se utiliza ese, 
        //sinó se utiliza el id del sistema al que pertenece el usuario.
        $sistema = $pf->get('sistema') ? $pf->get('sistema') : $this->getUser()->getSistema()->getId();
        
        $pacientes = $this->getDoctrine()->getRepository(Paciente::class)->findAllPacientesInternados($sistema);        
        return new JsonResponse($pacientes, 200);
    }

    /**
     * @Route("/egresados", name="pacientes_egresados", methods={"GET"})
     * @SWG\Response(response=200, description="Listado de pacientes egresados")
     * @SWG\Tag(name="Paciente")
     *      
     */
    public function getPacientesEgresados(Request $request): Response
    {        
        $pacientes = $this->getDoctrine()->getRepository(Paciente::class)->findAllPacientesEgresados();        
        return new JsonResponse($pacientes, 200);
    }

    /**
     * @Route("/fallecidos", name="pacientes_fallecidos", methods={"GET"})
     * @SWG\Response(response=200, description="Listado de pacientes egresados")
     * @SWG\Tag(name="Paciente")
     *      
     */
    public function getPacientesFallecidos(Request $request): Response
    {        
        $pacientes = $this->getDoctrine()->getRepository(Paciente::class)->findAllPacientesFallecidos();        
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

      $serializer = $this->get('jms_serializer'); 
      $paciente = $this->getDoctrine()->getRepository(Paciente::class)->findPaciente($pf->get('id'));
      if (!$paciente) {

        $error = [ 
          "message" => "El paciente id ".$pf->get('id')." no existe",
          "title" => "No se encontró el paciente",
          "relocate" => "go back",
        ];
  
        return new Response($serializer->serialize($error, "json"), 404);
      }

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

      $dni = (int)$pf->get('dni');

      $serializer = $this->get('jms_serializer'); 

      if ($this->getDoctrine()->getRepository(Paciente::class)->findBy(["dni" => $dni])) {

        $error = [ 
          "message" => "El paciente con dni: ".$dni." ya se encuentra cargado en el sistema",
          "title" => "Paciente ya existente",
        ];
        return new Response($serializer->serialize($error, "json"), 400);

      }

      try {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->getConnection()->beginTransaction();

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
        $entityManager->getConnection()->commit();
        
      } catch (\Throwable $th) {

        $entityManager->getConnection()->rollBack();

        $error = [ 
          "message" => "Se produjo un error al intentar crear el paciente",
        ];
  
        return new Response($serializer->serialize($error, "json"), 500);

      }
      
      return new Response($serializer->serialize($paciente, "json"), 200);
     
    }

    /**
     * @Route("/update/{id}", name="paciente_update", methods={"POST"})
     * @SWG\Response(response=200, description="Paciente actualizado exitosamente")
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
    public function update(Request $request, ParamFetcher $pf): Response
    {

      $serializer = $this->get('jms_serializer'); 
      $dni = (int)$pf->get('dni');
      $entityManager = $this->getDoctrine()->getManager();
      $paciente = $entityManager->getRepository(Paciente::class)->findBy(["dni" => $dni]);

      if (!$paciente) {

        $error = [ 
          "message" => "No se encontró el paciente con dni: ".$dni,
          "title" => "Paciente inexistente",
        ];

        return new Response($serializer->serialize($error, "json"), 400);

      }

      try {

        $entityManager->getConnection()->beginTransaction();

        $paciente[0]->setApellido($pf->get('apellido'));
        $paciente[0]->setNombre($pf->get('nombre'));
        $paciente[0]->setDireccion($pf->get('direccion'));
        $paciente[0]->setTelefono($pf->get('telefono'));
        $paciente[0]->setEmail($pf->get('email'));
        $paciente[0]->setFechaNacimiento(date_create($pf->get('fecha_nacimiento')));
        $paciente[0]->setObraSocial($pf->get('obra_social'));
        $paciente[0]->setAntecedentes($pf->get('antecedentes'));
        $paciente[0]->setContactoNombre($pf->get('contacto_nombre'));
        $paciente[0]->setContactoApellido($pf->get('contacto_apellido'));
        $paciente[0]->setContactoTelefono($pf->get('contacto_telefono'));
        $paciente[0]->setContactoParentesco($pf->get('contacto_parentesco'));
        $entityManager->flush();
        $entityManager->getConnection()->commit();
        
      } catch (\Throwable $th) {

        $entityManager->getConnection()->rollBack();

        $error = [ 
          "message" => "Se produjo un error al intentar actualizar el paciente",
        ];
  
        return new Response($serializer->serialize($error, "json"), 500);

      }
      
      return new Response($serializer->serialize($paciente, "json"), 200);
     
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
      
      $serializer = $this->get('jms_serializer'); 

      if ($yaExisteLaRelacion) {

        $error = [
          "message" => "Ese médico ya se encuentra asignado al paciente",
        ];
        
        return new Response($serializer->serialize($error, "json"), 400);
        
      }

      $userPaciente= new UserPaciente($paciente, $medico);
      
      $entityManager->persist($userPaciente);
      $entityManager->flush();

      return new Response($serializer->serialize($userPaciente, "json"), 200);
     
    }

    /**
     * @Route("/existsWithDni", name="exists_with_dni", methods={"POST"})
     * @SWG\Response(response=200, description="Existe o no existe un paciente con un dni especifico")
     * @SWG\Tag(name="Paciente")
     * @RequestParam(name="dni", strict=true, nullable=false, allowBlank=false, description="Dni")
     * 
     * @param ParamFetcher $pf
     */
    public function existsWithDni(Request $request, ParamFetcher $pf): Response
    {
      $serializer = $this->get('jms_serializer'); 
      $dni = (int)$pf->get('dni');
      if ($this->getDoctrine()->getRepository(Paciente::class)->findBy(["dni" => $dni])) {
        $response = [ 
          "title" => "Paciente existente",
          "message" => "El paciente con dni: ".$dni." ya se encuentra cargado en el sistema",
          "exists" => true,
          "dni" => $dni,
        ];
        return new Response($serializer->serialize($response, "json"), 200);

      }else{
        $response = [ 
          "title" => "Paciente inexistente",
          "message" => "El paciente con dni: ".$dni." no se encuentra cargado en el sistema",
          "exists" => false,
          "dni" => $dni,
        ];
        return new Response($serializer->serialize($response, "json"), 200);
      }

    }

}
