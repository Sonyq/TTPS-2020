<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
    <side-bar :sidebar-item-color="sidebarBackground">
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link v-if="!jwtToken" to="/login">
        <md-icon>person</md-icon>
        <p>Iniciar sesión</p>
      </sidebar-link>
      <sidebar-link v-if="jwtToken && esJefe" to="/sistemas">
        <md-icon>local_hospital</md-icon>
        <p>Sistemas</p>
      </sidebar-link>
      <sidebar-link
        v-if="jwtToken && !esAdmin"
        :to="{
          name: 'Pacientes',
          params: {
            sistemaNombre: loggedUser.sistemaNombre,
            sistemaId: loggedUser.sistemaId
          }
        }"
      >
        <md-icon>person</md-icon>
        <p>Pacientes</p>
      </sidebar-link>
      <sidebar-link v-if="jwtToken && esAdmin" to="/reglas">
        <md-icon>rule</md-icon>
        <p>Reglas del Sistema</p>
      </sidebar-link>
      <sidebar-link v-if="jwtToken && !esAdmin" to="/alertas">
        <md-icon>notification_important</md-icon>
        <p>Alertas</p>
      </sidebar-link>
      <sidebar-link v-if="jwtToken" to="/logout">
        <md-icon>keyboard_backspace</md-icon>
        <p>Cerrar sesión</p>
      </sidebar-link>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content></dashboard-content>

      <!-- <content-footer v-if="!$route.meta.hideFooter"></content-footer> -->
    </div>
  </div>
</template>

<script>
import TopNavbar from "./TopNavbar.vue";
// import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "@/pages/Layout/MobileMenu.vue";

export default {
  components: {
    TopNavbar,
    DashboardContent,
    // ContentFooter,
    MobileMenu
  },
  data() {
    return {
      sidebarBackground: "green",
      usuarioLocal: ""
    };
  },
  mounted() {
    // events.$on(
    //   "loading_user:finish",
    //   () => (this.loggedUser = this.loggedUser.roles)
    // );
    // events.$on("user:logout", () => (this.usuarioLocal = ""));
  },
  computed: {
    esJefe() {
      if (this.loggedUser.roles) {
        return this.loggedUser.roles.includes("ROLE_JEFE");
      }
    },
    esAdmin() {
      if (this.loggedUser.roles) {
        return this.loggedUser.roles.includes("ROLE_ADMIN");
      }
    }
  }
};
</script>
