<template>
  <div class="content">
    <div class="md-layout">
      <div
        class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33"
      >
        <md-field>
          <label>Nombre de usuario</label>
          <md-input v-model="username"></md-input>
        </md-field>

        <md-field>
          <label>Contraseña</label>
          <md-input v-model="password"></md-input>
        </md-field>

        <md-button class="md-info" @click="login">Aceptar</md-button>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  components: {
  },
  data() {
    return {
      username: '',
      password: '',
    }
  },
  methods: {
    login(){
      var credentials = {
          _username : this.username,
          _password : this.password
      };
      axios
      .post(this.burl('/api/login_check'), credentials, {dataType :  "text"}) //mando el post
      .then((response) => {
        if (response.status === 200) {
          this.jwtToken = response.data['token']; //seteo el token
          this.$router.push('/'); // con esto me cambio de vista
        }        
      })
      .catch((error) => {
        this.$swal('Usuario o contraseña incorrectos', '', 'error')
        //  events.$emit('alert:error', 'Usuario o contraseña incorrecta');//emito el error
      })
    }
  },
  computed: {
    canSubmit() {
        return !(this.username && this.password)
    },
  }
}
</script>
