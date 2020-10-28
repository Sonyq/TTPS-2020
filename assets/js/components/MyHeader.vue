<template>
    <v-app-bar
      color="deep-purple accent-4"
      dense
      dark
    >
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title>TTPS-2020-G6</v-toolbar-title>

      <v-spacer></v-spacer>

      
        <v-btn to="/app/login" active-class="no-active" icon >
          <v-icon>mdi-account-arrow-left</v-icon>
        </v-btn>

      <v-menu
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

        <v-list>
          <v-list-item
            v-for="n in 5"
            :key="n"
            @click="() => {}"
          >
            <v-list-item-title>Option {{ n }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
</template>

<script>

export default {
  data() {
    return {
      mantenimiento: false,
      loading_config: true,
      authenticated_user: false,
      base_url: window.location.host
    }
  },
  mounted() {
    events.$on('loading_config:finish', () => this.loading_config = false)
    events.$on('loading_user:finish', () => this.authenticated_user = true)
    events.$on('mantenimiento:active',() => this.mantenimiento = true)
    events.$on('mantenimiento:inactive',() => this.mantenimiento = false)
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