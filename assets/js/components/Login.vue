<template>

        <p>login test</p>
</template>

<script>

export default {
  data() {
    return {
      name: '',
      pass: '',
    }
  },
  methods: {
    login(){
      var credentials = {
          _username : this.name,
          _password : this.pass
      };
      axios
      .post(this.burl('/api/login_check'),credentials) //mando el post
      .then((response) => {
        if (response.status === 200) {
          this.jwtToken = response.data['token']; //seteo el token
          this.$router.push('/'); // con esto me cambio de vista
        }
      })
      .catch((error) => {
         events.$emit('alert:error','Usuario o contraseña incorrecta');//emito el error
      })
    }
  },
}
</script>
