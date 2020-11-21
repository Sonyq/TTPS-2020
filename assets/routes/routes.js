import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";

import Dashboard from "@/pages/Dashboard.vue";
import Login from "@/pages/Login.vue";
import Internaciones from "@/pages/Pacientes/Internaciones.vue";
import NuevoPaciente from "@/pages/Pacientes/NuevoPaciente.vue";
import VerPaciente from "@/pages/Pacientes/VerPaciente.vue";
import NuevaEvolucion from "@/pages/Evoluciones/NuevaEvolucion.vue";
import NuevaInternacion from "@/pages/Internaciones/NuevaInternacion.vue";
import Sistemas from "@/pages/Sistemas/Sistemas.vue";
import Logout from "@/pages/Logout.vue";

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
        path: "internaciones/:sistemaId?/:sistemaNombre?",
        name: "Internaciones",
        component: Internaciones,
        props: true
      },
      {
        path: "nuevoPaciente",
        name: "Agregar Paciente",
        component: NuevoPaciente
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
      }
    ]
  }
];

export default routes;
