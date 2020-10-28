<template>
  <div> 
    <v-app-bar
      color="blue accent-4"
      dark
    >

      <v-toolbar-title>SegCo</v-toolbar-title>

      <v-spacer></v-spacer>

      <div v-if="authenticated_user">

        <p>{{ loggedUser.first_name }} {{ loggedUser.last_name }}</p>

        <v-btn text active-class="no-active" @click="logout">
          Salir         
        </v-btn>
        <v-icon>mdi-account-arrow-right</v-icon>
        
      </div>

      <div v-else>

        <v-btn text to="/app/login" active-class="no-active">
          Iniciar sesión
        </v-btn>
        <v-icon>mdi-account-arrow-right</v-icon>

      </div>

      <!-- <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
          >
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

      </v-menu> -->


    </v-app-bar>
  </div>
</template>

<script>

export default {
  data() {
    return {
      authenticated_user: false,
      base_url: window.location.host
    }
  },
  mounted() {
    events.$on('loading_user:finish', () => this.authenticated_user = true)
    events.$on('user:logout', () => this.logout(true))
  },
  methods: {
    logout(recursive = false) {
      if(!recursive){
        events.$emit('user:logout')
      }
      this.authenticated_user = false
      axios.defaults.headers.common['Authorization'] = null
      localStorage.removeItem('token')
      this.$root.$data.store_token = ''
      this.jwtToken.clear
      this.loggedUser.clear
      this.$router.replace("/")
    }
  }
}

</script>
<style scoped>
/* esto evita un bug pelotudo de los botones */
.v-btn--active.no-active::before {                                                                             
  opacity: 0 !important;
}
</style>