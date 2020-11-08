<template>
  <div>
   
    
    <md-toolbar v-if="successMessage != null">
      <h3 class="md-title" style="flex: 1">{{ successMessage }}</h3>
      <md-button class="md-icon-button">
        <md-icon>close</md-icon>
      </md-button>
    </md-toolbar>

    <form>
      <div class="md-layout">
        <md-card class="md-layout-item md-small-size-50 md-size-50">
          <md-card-header data-background-color="green">
            <h4 class="title">Datos filiatorios</h4>
            <!-- <p class="category">Ingrese los datos del nuevo paciente</p> -->
          </md-card-header>
          <md-card-content>
            <div class="md-layout">
              <div class="md-layout-item md-small-size-50 md-size-50">
                <md-field>
                  <label>DNI</label>
                  <md-input v-model="dni" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-50 md-size-50">
                <md-field>
                  <label>Fecha de nacimiento</label>
                  <md-input v-model="fechaNacimiento" type="text"></md-input>
                </md-field>
              </div>
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
              <div class="md-layout-item md-small-size-50 md-size-50">
                <md-field>
                  <label>Obra social</label>
                  <md-input v-model="obraSocial" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-50 md-size-50">
                <md-field>
                  <label>Email</label>
                  <md-input v-model="email" type="email"></md-input>
                </md-field>
              </div>
            </div>
          </md-card-content>
        </md-card>
        <div class="md-layout">
          <md-card class="md-layout-item md-small-size-50 md-size-100">
            <md-card-header data-background-color="green">
              <h4 class="title">Datos de contacto Paciente</h4>
              <!-- <p class="category">Ingrese los datos de contacto del paciente</p> -->
            </md-card-header>
            <md-card-content>
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
            </md-card-content>
          </md-card>
    
          <md-card class="md-layout-item md-small-size-50 md-size-100">
            <md-card-header data-background-color="green">
              <h4 class="title">Antecedentes personales</h4>
              <!-- <p class="category">Enfermedades previas del paciente a modo de resumen</p> -->
            </md-card-header>
            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-size-100 right">
                  <md-field maxlength="5">
                    <label>Antecedentes personales</label>
                    <md-textarea v-model="antecedentesPersonales"></md-textarea>
                  </md-field>
                </div>
              </div>
            </md-card-content>
          </md-card>
        </div>
      </div>
      <div class="md-layout">
        <div class="md-layout-item md-size-100 text-right">
          <md-button class="md-raised md-success" v-on:click="agregarPaciente()" >Agregar Paciente</md-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>

export default {
  data() {
    return {
      dni: '39597615',
      apellido: 'Manciagli',
      nombre: 'Leandro',
      fechaNacimiento: '19960417',
      telefono: '2214207932',
      domicilio: '528',
      obraSocial: 'IOMA',
      email: 'leandro@gmail.com',
      apellidoContacto: null,
      nombreContacto: null,
      telefonoContacto: null,
      relacionContacto: null,
      antecedentesPersonales: "Epoc desde los 20 años.",
      successMessage: "Paciente agregado",
    };
  },
  created() {
    
  },
  methods: {
    async agregarPaciente() {
      let loader = this.$loading.show()
      let formData = {
        'dni'                 : this.dni,
        'apellido'            : this.apellido,
        'nombre'              : this.nombre,
        'direccion'           : this.domicilio,
        'telefono'            : this.telefono,
        'email'               : this.email,
        'fecha_nacimiento'    : this.fechaNacimiento,
        'obra_social'         : this.obraSocial,
        'antecedentes'        : this.antecedentesPersonales,
        'contacto_nombre'     : this.nombreContacto,
        'contacto_apellido'   : this.apellidoContacto,
        'contacto_telefono'   : this.telefonoContacto,
        'contacto_parentesco' : this.parentescoContacto
      }
      const response = await axios.post(this.burl('/api/paciente/new'), formData)
      console.log(response)
      // if (response.status == 200){
      //   this.successMessage = response.data
      // }
      loader.hide();
    }
  }
}

</script>

<style>

</style>
