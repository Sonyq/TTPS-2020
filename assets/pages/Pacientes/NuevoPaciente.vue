<template>
  <div>
    <form>
      <md-card>
        <md-card-header data-background-color="green">
          <h3 class="title">Nuevo Paciente</h3>
        </md-card-header>

        <md-card-content>
          <div class="md-layout">
            <div class="md-layout-item md-small-size-50 md-size-50">
              <h4 class="title">Datos filiatorios</h4>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>DNI</label>
                    <md-input v-model="dni" type="text"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-datepicker
                    v-model="fechaNacimiento"
                    md-immediately
                    placeholder="Fecha de nacimiento"
                  >
                    <label>Fecha de nacimiento</label>
                  </md-datepicker>
                </div>
              </div>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Apellido</label>
                    <md-input v-model="apellido" type="text"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Nombre</label>
                    <md-input v-model="nombre" type="text"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Teléfono</label>
                    <md-input v-model="telefono" type="text"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Domicilio</label>
                    <md-input v-model="domicilio" type="text"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Email</label>
                    <md-input v-model="email" type="email"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Obra social</label>
                    <md-input v-model="obraSocial" type="text"></md-input>
                  </md-field>
                </div>
              </div>
            </div>

            <div class="md-layout-item md-small-size-100 md-size-50">
              <h4 class="title">Datos de algún contacto</h4>

              <div class="md-layout">
                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Apellido</label>
                    <md-input v-model="apellidoContacto" type="text"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Nombre</label>
                    <md-input v-model="nombreContacto" type="text"></md-input>
                  </md-field>
                </div>
              </div>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Teléfono</label>
                    <md-input v-model="telefonoContacto" type="text"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>Relación</label>
                    <md-input v-model="relacionContacto" type="text"></md-input>
                  </md-field>
                </div>
              </div>

              <h4 class="title">Antecedentes personales</h4>

              <div class="md-layout">
                <div class="md-layout-item md-size-100 right">
                  <md-field maxlength="5">
                    <label
                      >Ingrese un resumen de las enfermedades previas del
                      paciente</label
                    >
                    <md-textarea v-model="antecedentesPersonales"></md-textarea>
                  </md-field>
                </div>
              </div>
            </div>

            <div class="md-layout-item md-size-100 text-right">
              <md-button
                class="md-raised md-success"
                v-on:click="agregarPaciente()"
                >Agregar Paciente</md-button
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
  data() {
    return {
      dni: null,
      apellido: null,
      nombre: null,
      fechaNacimiento: null,
      telefono: null,
      domicilio: null,
      obraSocial: null,
      email: null,
      apellidoContacto: null,
      nombreContacto: null,
      telefonoContacto: null,
      relacionContacto: null,
      antecedentesPersonales: null
    };
  },
  created() {},
  methods: {
    async agregarPaciente() {
      let loader = this.$loading.show();
      let formData = {
        dni: this.dni,
        apellido: this.apellido,
        nombre: this.nombre,
        direccion: this.domicilio,
        telefono: this.telefono,
        email: this.email,
        fecha_nacimiento: this.fechaNacimiento,
        obra_social: this.obraSocial,
        antecedentes: this.antecedentesPersonales,
        contacto_nombre: this.nombreContacto,
        contacto_apellido: this.apellidoContacto,
        contacto_telefono: this.telefonoContacto,
        contacto_parentesco: this.parentescoContacto
      };
      try {
        const response = await axios.post(
          this.burl("/api/paciente/new"),
          formData
        );
        this.$swal
          .fire({
            title: "Paciente agregado",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
          })
          .then(() => {
            this.$router.replace({
              path: "nuevaInternacion/" + response.data.id
            });
          });
      } catch (error) {
        console.log(error);
      }
      loader.hide();
    }
  }
};
</script>

<style></style>
