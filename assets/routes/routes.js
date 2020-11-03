import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";

import Dashboard from "@/pages/Dashboard.vue";
import Home from "@/pages/Home.vue";
import Login from "@/pages/Login.vue"
import Pacientes from "@/pages/Pacientes/Pacientes.vue"
import NuevoPaciente from "@/pages/Pacientes/NuevoPaciente.vue"
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
        path: "home",
        name: "Inicio",
        component: Home
      },
      {
        path: "login",
        name: "Iniciar sesión",
        component: Login
      },
      {
        path: "pacientes",
        name: "Pacientes",
        component: Pacientes
      },
      {
        path: "pacientes/nuevo",
        name: "Agregar Paciente",
        component: NuevoPaciente
      },
      {
        path: "sistemas",
        name: "Sistemas",
        component: Sistemas
      }
    ]
  }
];

export default routes;
