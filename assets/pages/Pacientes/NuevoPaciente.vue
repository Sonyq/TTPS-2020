<template>
  <div>
    <form>
      <md-card>
        <md-card-header data-background-color="green">
          <h3 class="title" v-if="pacienteId">Editar Paciente</h3>
          <h3 class="title" v-else>Nuevo Paciente</h3>
        </md-card-header>

        <md-card-content>
          <div class="md-layout">
            <div class="md-layout-item md-small-size-50 md-size-50">
              <span class="md-title">Datos filiatorios</span>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-50 md-size-50">
                  <md-field>
                    <label>DNI</label>
                    <md-input v-model="dni" disabled type="text"></md-input>
                  </md-field>
                </div>

                <div
                  class="md-layout-item md-small-size-50 md-size-50"
                  style="margin-top: 23px"
                >
                  <datepicker
                    v-model="fechaNacimiento"
                    :lang="this.$root.datePickerOptions"
                    placeholder="Fecha de nacimiento"
                    :disabled-date="this.$root.datePickerOptions.disabledDate"
                    format="DD/MM/YYYY"
                  >
                  </datepicker>
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
                  <!-- <md-field>
                    <label>Obra social</label>
                    <md-input v-model="obraSocial" type="text"></md-input>
                  </md-field> -->

                  <md-field>
                    <label for="obraSocial">Obra Social</label>
                    <md-select v-model="obraSocial" name="obraSocial" id="obraSocial" md-dense>
                      <md-option value="APRES">APRES</md-option>
                      <md-option value="IOMA">IOMA</md-option>
                      <md-option value="OSDE">OSDE</md-option>
                      <md-option value="OSPE">OSPE</md-option>
                      <md-option value="PAMI">PAMI</md-option>
                    </md-select>
                  </md-field>
                
                </div>
              </div>
            </div>

            <div class="md-layout-item md-small-size-100 md-size-50">
              <span class="md-title">Datos de algún contacto</span>

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

              <span class="md-title">Antecedentes personales</span>
          
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
                v-if="pacienteId"
                v-on:click="editarPaciente()"
                >Editar Paciente</md-button
              >

              <md-button
                class="md-raised md-success"
                v-else
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
import Datepicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/es";

export default {
  components: {
    Datepicker
  },
  name: 'BasicSelect',
  props: ["pacienteId"],
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
  created() {
    if (this.pacienteId) {
      this.getPaciente();
    }else{
      this.existsWithDni();
    }
  },
  methods: {

    async getPaciente() {
      events.$emit("loading:show");
      axios
        .get(this.burl("/api/paciente/getPaciente?id=" + this.pacienteId))
        .then(response => {
          this.dni = response.data.dni,
          this.apellido = response.data.apellido,
          this.nombre = response.data.nombre,
          this.fechaNacimiento = new Date(response.data.fecha_nacimiento),
          this.telefono = response.data.telefono,
          this.domicilio = response.data.direccion,
          this.obraSocial = response.data.obra_social,
          this.email = response.data.email,
          this.apellidoContacto = response.data.contacto_apellido,
          this.nombreContacto = response.data.contacto_nombre,
          this.telefonoContacto = response.data.contacto_telefono,
          this.relacionContacto = response.data.contacto_parentesco,
          this.antecedentesPersonales = response.data.antecedentes
        });
       events.$emit("loading:hide");
    },
    async agregarPaciente() {
      events.$emit("loading:show");
      let formData = {
        dni: this.dni,
        apellido: this.apellido,
        nombre: this.nombre,
        direccion: this.domicilio,
        telefono: this.telefono,
        email: this.email,
        fecha_nacimiento: this.formatDate(this.fechaNacimiento.toISOString()),
        obra_social: this.obraSocial,
        antecedentes: this.antecedentesPersonales,
        contacto_nombre: this.nombreContacto,
        contacto_apellido: this.apellidoContacto,
        contacto_telefono: this.telefonoContacto,
        contacto_parentesco: this.parentescoContacto
      };
      const response = await axios.post(
        this.burl("/api/paciente/new"),
        formData
      );
      this.$swal
        .fire({
          title: "Paciente creado",
          icon: "success",
          timer: 2000,
          showConfirmButton: false
        })
        .then(() => {
          this.$router.push({
            path: "nuevaInternacion/" + response.data.id
          });
        });
      events.$emit("loading:hide");
    },
    async editarPaciente() {
      events.$emit("loading:show");
      let formData = {
        dni: this.dni,
        apellido: this.apellido,
        nombre: this.nombre,
        direccion: this.domicilio,
        telefono: this.telefono,
        email: this.email,
        fecha_nacimiento: this.formatDate(this.fechaNacimiento.toISOString()),
        obra_social: this.obraSocial,
        antecedentes: this.antecedentesPersonales,
        contacto_nombre: this.nombreContacto,
        contacto_apellido: this.apellidoContacto,
        contacto_telefono: this.telefonoContacto,
        contacto_parentesco: this.parentescoContacto
      };
      const response = await axios.post(
        this.burl("/api/paciente/update/" + this.pacienteId),
        formData
      );
      this.$swal
        .fire({
          title: "Paciente actualizado",
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
    },
    async existsWithDni() {
      this.$swal
        .fire({
          title: 'Por favor ingrese el número de DNI del nuevo paciente',
          input: 'text',
          confirmButtonText: 'Aceptar',
          showLoaderOnConfirm: true,
          showCancelButton: true,
          cancelButtonText: 'Volver',
          allowOutsideClick: false,
          confirmButtonColor: '#4caf50',
          preConfirm: (result) => {
            let data = { dni: result }
            return axios
              .post("api/paciente/existsWithDni", data)
              .then(response => {
                if (response.status != 200) {
                  throw new Error("Something went wrong");
                }
                return response.data;
              })
              .catch(error => {
                this.$swal.showValidationMessage(`Request failed: ${error}`);
              });
          },
          allowOutsideClick: () => !this.$swal.isLoading()
        }).then((response) => {
          if (response.isDismissed) {
            return this.$router.go(-1);
          }else if (response.value.exists) {
            this.$swal.fire({
              title: response.value.title,
              text: response.value.message,
              icon: "error",
              confirmButtonText: 'Aceptar',
              allowOutsideClick: false,
              confirmButtonColor: '#4caf50',
            }).then((response) => {
              this.existsWithDni();
            })
          }else{
            this.dni = response.value.dni;
          }
        })
    }
  }
};
</script>

<style></style>
