import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";

import Dashboard from "@/pages/Dashboard.vue";
import Login from "@/pages/Login.vue"
import Pacientes from "@/pages/Pacientes/Pacientes.vue"
import NuevoPaciente from "@/pages/Pacientes/NuevoPaciente.vue"
import NuevaEvolucion from "@/pages/Evoluciones/NuevaEvolucion.vue"
import Sistemas from "@/pages/Sistemas/Sistemas.vue"

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
    redirect: "/dashboard",
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
        path: "sistemas",
        name: "Sistemas",
        component: Sistemas
      },
      {
        path: 'pacientes',
        name: "Pacientes",
        component: Pacientes,
        props: true
      },
      {
        path: "pacientes/nuevo",
        name: "Agregar Paciente",
        component: NuevoPaciente
      },
      {
        path: "evoluciones/nueva",
        name: "Nueva Evolución",
        component: NuevaEvolucion,
        props: true
      }
    ]
  }
];

export default routes;
