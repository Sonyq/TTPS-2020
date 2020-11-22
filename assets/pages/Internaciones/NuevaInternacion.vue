<template>
  <div>
    <form>
      <md-card>
        <md-card-header data-background-color="green">
          <h3 class="title">Nueva Internación</h3>
        </md-card-header>

        <md-card-content>
          <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-100">
              <md-datepicker v-model="fechaInicioSintomas" md-immediately>
                <label>Fecha de inicio de síntomas</label>
              </md-datepicker>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-100">
              <md-datepicker v-model="fechaDiagnostico" md-immediately>
                <label>Fecha de diagnóstico</label>
              </md-datepicker>
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
export default {
  props: ["pacienteId"],
  data() {
    return {
      fechaInicioSintomas: null,
      fechaDiagnostico: null,
      descripcion: null,
      successMessage: "Internación agregada"
    };
  },

  created() {},

  methods: {
    async agregarInternacion() {
      events.$emit("loading:show");
      let formData = {
        fecha_inicio_sintomas: this.fechaInicioSintomas,
        fecha_diagnostico: this.fechaDiagnostico,
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
          this.$router.push({ name: "Ver Paciente", params: { pacienteId: this.pacienteId } });
        });
      events.$emit("loading:hide");
    }
  }
};
</script>

<style></style>
