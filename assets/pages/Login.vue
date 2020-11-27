<template>
  <div class="content">
    <div class="md-layout">
      <div
        class="md-layout-item md-medium-size-75 md-xsmall-size-75 md-size-33"
      >
        <md-field>
          <label>Nombre de usuario</label>
          <md-input v-model="username" @keyup.enter="login"></md-input>
        </md-field>

        <md-field>
          <label>Contraseña</label>
          <md-input v-model="password" @keyup.enter="login"></md-input>
        </md-field>

        <md-button class="md-success" @click="login" :disabled="canSubmit"
          >Aceptar</md-button
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      username: "",
      password: ""
    };
  },
  methods: {
    login() {
      events.$emit("loading:show");
      var credentials = {
        _username: this.username,
        _password: this.password
      };
      axios
        .post(this.burl("/api/login_check"), credentials, { dataType: "text" }) //mando el post
        .then(response => {
          if (response.status === 200) {
            this.jwtToken = response.data["token"]; //seteo el token
            this.$root.fetchLoggedUser();
            events.$emit("loading:hide");
            this.$router.push("/pacientes"); // con esto me cambio de vista
          }
        })
        .catch(error => {
          events.$emit("loading:hide");
          this.$swal("Usuario o contraseña incorrectos", "", "error");
        });
    }
  },
  computed: {
    canSubmit() {
      return !(this.username && this.password);
    }
  }
};
</script>
