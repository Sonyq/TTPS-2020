<template>
 
</template>

<script>

import { ValidationProvider } from 'vee-validate'

export default {
  components: {
      ValidationProvider,
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
