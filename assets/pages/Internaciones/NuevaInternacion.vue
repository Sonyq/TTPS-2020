<template>
  <div>
    <form>
      <md-card>
        <md-card-header data-background-color="green">
          <h3 class="title">Nueva Internación</h3>
        </md-card-header>

        <md-card-content>
          <div class="md-layout">
            <div
              class="md-layout-item md-small-size-100 md-size-100"
              style="margin-top: 20px"
            >
              <datepicker
                v-model="fechaInicioSintomas"
                :lang="this.$root.datePickerOptions"
                placeholder="Fecha inicio síntomas"
                :disabled-date="this.$root.datePickerOptions.disabledDate"
                format="DD/MM/YYYY"
              >
              </datepicker>
            </div>
            <div
              class="md-layout-item md-small-size-100 md-size-100"
              style="margin-top: 20px; margin-bottom: 10px;"
            >
              <datepicker
                v-model="fechaDiagnostico"
                :lang="this.$root.datePickerOptions"
                placeholder="Fecha diagnóstico"
                :disabled-date="this.$root.datePickerOptions.disabledDate"
                format="DD/MM/YYYY"
              >
              </datepicker>
            </div>
            <div class="md-layout-item md-size-100 right">
              <md-field maxlength="5">
                <label>Descripción</label>
                <md-textarea v-model="descripcion"></md-textarea>
              </md-field>
            </div>
            <div class="md-layout-item md-size-100 right">
              <md-button
                class="md-raised md-success"
                v-on:click="agregarInternacion()"
                >Agregar Internación</md-button
              >
            </div>
          </div>
        </md-card-content>
      </md-card>
    </form>
  </div>
</template>

<script>
import Datepicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/es";

export default {
  components: {
    Datepicker
  },
  props: ["pacienteId"],
  data() {
    return {
      fechaInicioSintomas: null,
      fechaDiagnostico: null,
      descripcion: null
    };
  },
  methods: {
    async agregarInternacion() {
      events.$emit("loading:show");
      let formData = {
        fecha_inicio_sintomas: this.formatDate(
          this.fechaInicioSintomas.toISOString()
        ),
        fecha_diagnostico: this.formatDate(this.fechaDiagnostico.toISOString()),
        sintomas: this.descripcion,
        pacienteId: this.pacienteId
      };
      const response = await axios.post(
        this.burl("/api/internacion/new"),
        formData
      );
      this.$swal
        .fire({
          title: "Internación creada",
          icon: "success",
          timer: 2000,
          showConfirmButton: false
        })
        .then(() => {
          this.$router.push({
            name: "Ver Paciente",
            params: { pacienteId: this.pacienteId }
          });
        });
      events.$emit("loading:hide");
    }
  }
};
</script>

<style></style>
