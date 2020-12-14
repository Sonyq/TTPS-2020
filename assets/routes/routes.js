import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";

import Dashboard from "@/pages/Dashboard.vue";
import Login from "@/pages/Login.vue";
import Pacientes from "@/pages/Pacientes/Pacientes.vue";
import NuevoPaciente from "@/pages/Pacientes/NuevoPaciente.vue";
import VerPaciente from "@/pages/Pacientes/VerPaciente.vue";
import NuevaEvolucion from "@/pages/Evoluciones/NuevaEvolucion.vue";
import NuevaInternacion from "@/pages/Internaciones/NuevaInternacion.vue";
import VerInternacion from "@/pages/Internaciones/VerInternacion.vue";
import Sistemas from "@/pages/Sistemas/Sistemas.vue";
import Logout from "@/pages/Logout.vue";
import Reglas from "@/pages/Reglas/Reglas.vue";
import NuevaRegla from "@/pages/Reglas/NuevaRegla.vue";

/*
Si no quiero agregar el footer poner la opcion   hideFooter: true ejemplo: 
{
  path: "notifications",
  name: "Notifications",
  meta: {
    hideFooter: true
  },
  component: Notifications
},
*/
const routes = [
  {
    path: "/",
    component: DashboardLayout,
    redirect: "/login",
    children: [
      {
        path: "dashboard",
        name: "Dashboard",
        component: Dashboard
      },
      {
        path: "login",
        name: "Iniciar sesión",
        component: Login
      },
      {
        path: "logout",
        name: "Cerrar sesión",
        component: Logout
      },
      {
        path: "sistemas",
        name: "Sistemas",
        component: Sistemas
      },
      {
        path: "pacientes/:sistemaId?/:sistemaNombre?",
        name: "Pacientes",
        component: Pacientes,
        props: true
      },
      {
        path: "paciente/:pacienteId?",
        name: "Paciente",
        component: NuevoPaciente,
        props: true
      },
      {
        path: "verPaciente/:pacienteId",
        name: "Ver Paciente",
        component: VerPaciente,
        props: true
      },
      {
        path: "nuevaEvolucion/:internacionId/:pacienteId",
        name: "Nueva Evolución",
        component: NuevaEvolucion,
        props: true
      },
      {
        path: "nuevaInternacion/:pacienteId",
        name: "Nueva Internación",
        component: NuevaInternacion,
        props: true
      },
      {
        path: "verInternacion/:internacionId",
        name: "Ver Internación",
        component: VerInternacion,
        props: true
      },
      {
        path: "reglas",
        name: "Reglas",
        component: Reglas,
        props: true
      },
      {
        path: "regla/:reglaId?",
        name: "Nueva Regla",
        component: NuevaRegla,
        props: true
      }
    ]
  }
];

export default routes;
