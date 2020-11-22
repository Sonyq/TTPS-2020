<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
    <!-- <notifications></notifications> -->

    <side-bar :sidebar-item-color="sidebarBackground">
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link v-if="!jwtToken" to="/login">
        <md-icon>person</md-icon>
        <p>Iniciar sesión</p>
      </sidebar-link>
      <sidebar-link v-if="jwtToken" to="/sistemas">
        <md-icon>person</md-icon>
        <p>Sistemas</p>
      </sidebar-link>
      <sidebar-link
        v-if="jwtToken"
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
      <sidebar-link v-if="jwtToken" to="/logout">
        <md-icon>person</md-icon>
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
      sidebarBackground: "green"
    };
  }
};
</script>
