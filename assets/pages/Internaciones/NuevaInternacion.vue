<template>
    <div>
        <form>
            <div class="md-layout">
                <md-card class="md-layout-item md-small-size-100 md-size-100">
                    <md-card-header data-background-color="green">
                        <h4 class="title">Nueva Internación</h4>
                    </md-card-header>
                    <md-card-content>
                        <div class="md-layout">
                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label>Fecha de inicio de síntomas</label>
                                <md-datepicker v-model="fechaInicioSintomas" md-immediately />
                            </div>
                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label>Fecha de diagnóstico</label>
                                <md-datepicker v-model="fechaDiagnostico" md-immediately />
                            </div>
                            <div class="md-layout-item md-size-100 right">
                                <md-field maxlength="5">
                                    <label>Descripción</label>
                                    <md-textarea v-model="descripcion"></md-textarea>
                                </md-field>
                            </div>
                            <div class="md-layout-item md-size-100 right">
                                <md-button class="md-raised md-success" v-on:click="agregarInternacion()" >Agregar Internación</md-button>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        </form>
    </div>
</template>

<script>

export default {
    data() {
        return {
        fechaInicioSintomas: null,
        fechaDiagnostico: null,
        descripcion: null,
        successMessage: "Internación agregada",
        };
    },

    created() {
    
    },

    methods: {
        async agregarInternacion() {
            let loader = this.$loading.show()
            let formData = {
                'fecha_inicio_sintomas' : this.fechaInicioSintomas,
                'fecha_diagnostico'     : this.fechaDiagnostico,
                'sintomas'              : this.descripcion,
                'pacienteId'            : '2' //hardcodeado hay que sacarlo
            }
            const response = await axios.post(this.burl('/api/internacion/new'), formData)
            if (response.status == 200){
                this.successMessage = response.data
            }
            loader.hide();
        }
    }
}

</script>

<style>

</style>
