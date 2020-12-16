<template>
  <md-toolbar md-elevation="0" class="md-transparent">
    <div class="md-toolbar-row">
      <div class="md-toolbar-section-start">
        <h3 v-if="loggedUser" class="md-title">
          {{ nombreUsuario }}, {{ rolUsuario }} {{ sistemaUsuario }}
        </h3>
      </div>
      <div class="md-toolbar-section-end">
        <md-button
          class="md-just-icon md-simple md-toolbar-toggle"
          :class="{ toggled: $sidebar.showSidebar }"
          @click="toggleSidebar"
        >
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </md-button>

        <div class="md-collapse">
          <md-list>
            <!-- <md-list-item href="#/">
              <i class="material-icons">dashboard</i>
              <p class="hidden-lg hidden-md">Dashboard</p>
            </md-list-item> -->

            <!-- <li class="md-list-item">
              <a
                href="#/notifications"
                class="md-list-item-router md-list-item-container md-button-clean dropdown"
              >
                <div class="md-list-item-content">
                  <drop-down>
                    <md-button
                      slot="title"
                      class="md-button md-just-icon md-simple"
                      data-toggle="dropdown"
                    >
                      <md-icon>notifications</md-icon>
                      <span class="notification">3</span>
                      <p class="hidden-lg hidden-md">Notifications</p>
                    </md-button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="#">You're now friend with Andrew</a></li>
                      <li><a href="#">Another Notification</a></li>
                      <li><a href="#">Another One</a></li>
                    </ul>
                  </drop-down>
                </div>
              </a>
            </li> -->

            <!-- <md-list-item href="#/user">
              <i class="material-icons">person</i>
              <p class="hidden-lg hidden-md">Profile</p>
            </md-list-item> -->
          </md-list>
        </div>
      </div>
    </div>
  </md-toolbar>
</template>

<script>
export default {
  data() {
    return {
      usuarioLocal: ""
    };
  },
  // created() {
  //   events.$on(
  //     //"loading_user:finish",
  //     "login:finish",
  //     () => (this.usuarioLocal = this.loggedUser)
  //   );
  //   events.$on("user:logout", () => (this.usuarioLocal = ""));
  // },
  methods: {
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
    }
  },
  computed: {
    nombreUsuario() {
      return this.loggedUser.first_name + " " + this.loggedUser.last_name;
    },
    rolUsuario() {
      if (this.loggedUser.roles) {
        if (this.loggedUser.roles.includes("ROLE_JEFE")) {
          return "Jefe";
        }else{
           if (this.loggedUser.roles.includes("ROLE_ADMIN")) {
             return "Administrador";
           }else{
             return "Médico";
           }
        }
        //return this.loggedUser.roles.includes("ROLE_JEFE") ? "Jefe" : "Médico";
      }
    },
    sistemaUsuario() {
      if (this.loggedUser.roles.includes("ROLE_ADMIN")) {
        return "";
      }else{
        return "de " + this.loggedUser.sistemaNombre;
      }
    }
  }
};
</script>

<style lang="css"></style>
