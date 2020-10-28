<template>
 
    <v-container>
      <v-row no-gutters>
        <v-col
          md="6"
          offset-md="3"
        >
          <v-card
            class="pa-2"
            outlined
            tile
          >

              <form>
                <validation-provider
                  v-slot="{ errors }"
                  name="Usuario"
                  rules="required"
                >
                  <v-text-field
                    v-model="username"
                    :error-messages="errors"
                    label="Usuario"
                    required
                  ></v-text-field>
                </validation-provider>

                <validation-provider
                  v-slot="{ errors }"
                  name="Contraseña"
                  rules="required"
                >
                  <v-text-field
                    v-model="password"
                    :error-messages="errors"
                    label="Contraseña"
                    required
                  ></v-text-field>
                </validation-provider>
                
                <!-- <validation-provider
                  v-slot="{ errors }"
                  rules="required"
                  name="checkbox"
                >
                  <v-checkbox
                    v-model="checkbox"
                    :error-messages="errors"
                    value="1"
                    label="Option"
                    type="checkbox"
                    required
                  ></v-checkbox>
                </validation-provider> -->

                <v-card-actions class="justify-center">
                  
                      <v-btn
                        class="mr-4"
                        color="primary"
                        type="submit"
                        :disabled="canSubmit"
                        @click="login"
                      >
                        Aceptar
                      </v-btn>
                    
                </v-card-actions>
                
              </form>

          </v-card>
        </v-col>
      </v-row>
    </v-container>

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
