<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="false" color="#4CAF50">
    </loading>

    <md-card>
      <md-card-header data-background-color="green">
        <span class="md-title" v-if="reglaId">Editar Regla</span>
        <span v-else class="md-title">Nueva Regla</span>
      </md-card-header>

      <md-card-content>
        <ValidationObserver v-slot="{ invalid }">
          <form @submit.prevent="submit">
            <div class="md-layout">
              <div class="md-layout-item md-size-20">
                <md-field>
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label for="evento">Evento</label>
                    <md-select v-model="evento" name="evento">
                      <md-option value="Temperatura > 39°"
                        >Temperatura > 39°</md-option
                      >
                      <md-option value="Presión arterial > 140"
                        >Presión arterial > 140</md-option
                      >
                    </md-select>
                    <span class="field-error">{{ errors[0] }}</span>
                  </ValidationProvider>
                </md-field>
              </div>

              <div class="md-layout-item md-size-20">
                <md-field>
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label>Expresión</label>
                    <md-textarea v-model="expresion"></md-textarea>
                    <span class="field-error">{{ errors[0] }}</span>
                  </ValidationProvider>
                </md-field>
              </div>

              <div class="md-layout-item md-size-20">
                <md-field>
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label for="accion">Acción</label>
                    <md-select v-model="accion" name="accion">
                      <md-option value="Alertar a los médicos"
                        >Alertar a los médicos</md-option
                      >
                    </md-select>
                    <span class="field-error">{{ errors[0] }}</span>
                  </ValidationProvider>
                </md-field>
              </div>

              <div class="md-layout-item md-size-40">
                &nbsp;
              </div>

              <div class="md-layout">
                <div class="md-layout-item md-size-30 text-left">
                  <md-button class="md-raised md-success" @click="volver()"
                    >Volver</md-button
                  >
                </div>

                <div class="md-layout-item md-size-30 text-right">
                  <md-button
                    type="submit"
                    class="md-raised md-success"
                    :disabled="invalid"
                    >Guardar</md-button
                  >
                </div>
              </div>
            </div>
          </form>
        </ValidationObserver>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  components: {
    Loading
  },
  props: ["reglaId"],
  data() {
    return {
      evento: null,
      expresion: null,
      accion: null,
      isLoading: false
    };
  },
  created() {
    if (this.reglaId) {
      this.getRegla();
    }
  },
  methods: {
    async getRegla() {
      this.isLoading = true;
      const response = await axios.get(
        this.burl("/api/reglas/show?id=" + this.reglaId)
      );
      this.evento = response.data.evento;
      this.expresion = response.data.expresion;
      this.accion = response.data.accion;
      this.isLoading = false;
    },
    async submit() {
      this.isLoading = true;
      let formData = {
        evento: this.evento,
        expresion: this.expresion,
        accion: this.accion
      };
      let url = this.reglaId
        ? "/api/reglas/update/" + this.reglaId
        : "/api/reglas/new";
      const response = await axios.post(this.burl(url), formData);
      this.$swal
        .fire({
          title: this.reglaId ? "Regla actualizada" : "Regla creada",
          icon: "success",
          timer: 2000,
          showConfirmButton: false
        })
        .then(() => {
          this.$router.push({
            name: "Reglas"
          });
        });
      this.isLoading = false;
    }
  },
  volver() {
    this.$router.go(-1);
  }
};
</script>

<style>
.field-error {
  color: red;
}
</style>
