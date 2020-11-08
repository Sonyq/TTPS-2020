<template>
  <div>
    <form>
			<md-card>
				<md-card-header data-background-color="green">
					<span class="md-title">Ver Paciente</span>
				</md-card-header>

				<md-card-content>

					<div class="md-layout">

						<div class="md-layout-item md-small-size-100 md-size-33">

    					<span class="md-title">Datos filiatorios</span>

							<div class="md-layout-item">
								<span class="md-body-1">Dni: {{ paciente.dni }}</span>
							</div>

							<div class="md-layout-item">
								<span class="md-body-1">Nombre: {{ paciente.nombre }}</span>
							</div>

							<div class="md-layout-item">
								<span class="md-body-1">Apellido: {{ paciente.apellido }}</span>
							</div>

							<div class="md-layout-item">
								<span class="md-body-1">Dirección: {{ paciente.direccion }}</span>
							</div>

							<div class="md-layout-item">
								<span class="md-body-1">Teléfono: {{ paciente.telefono }}</span>
							</div>

							<div class="md-layout-item">
								<span class="md-body-1">Email: {{ paciente.email }}</span>
							</div>

							<div class="md-layout-item">
								<span class="md-body-1">Fecha de nacimiento: {{ formatDate(paciente.fecha_nacimiento) }}</span>
							</div>

							<div class="md-layout-item">
								<span class="md-body-1">Obra Social: {{ paciente.obra_social}}</span>
							</div>

							<div>
								
								<md-dialog :md-active.sync="mostrarAntecedentes">
									<md-dialog-title>Antecedentes</md-dialog-title>
									
									<md-dialog-content>
										<span v-if="paciente.antecedentes" class="md-body">{{ paciente.antecedentes }}</span>
										<span v-else class="md-body">Sin antecedentes</span>
									</md-dialog-content>

									<md-dialog-actions>
										<md-button class="md-success" @click="mostrarAntecedentes = false">Cerrar</md-button>
									</md-dialog-actions>
								</md-dialog>
								
							</div>

							<md-button class="md-dense md-success" @click="mostrarAntecedentes = true">Ver Antecedentes</md-button>

							<div>
								
								<md-dialog :md-active.sync="mostrarContacto">
									<md-dialog-title>Datos de algún contacto</md-dialog-title>
									
									<md-dialog-content>
										<div class="md-layout-item">
											<span class="md-body-1">Nombre: {{ paciente.contacto_nombre }}</span>
										</div>

										<div class="md-layout-item">
											<span class="md-body-1">Apellido: {{ paciente.contacto_apellido }}</span>
										</div>

										<div class="md-layout-item">
											<span class="md-body-1">Teléfono: {{ paciente.contacto_telefono }}</span>
										</div>

										<div class="md-layout-item">
											<span class="md-body-1">Dirección: {{ paciente.contacto_relacion }}</span>
										</div>
									</md-dialog-content>

									<md-dialog-actions>
										<md-button class="md-success" @click="mostrarContacto = false">Cerrar</md-button>
									</md-dialog-actions>
								</md-dialog>
								
							</div>

							<md-button class="md-dense md-success" @click="mostrarContacto = true">Ver datos de algún contacto</md-button>							

						</div>

						<div v-show="internacionActual" class="md-layout-item md-small-size-100 md-size-33">

							<span class="md-title">Internación</span>

							<div class="md-layout-item">
								<span class="md-body-1">Fecha de inicio de síntomas:</span>
								<div class="md-layout-item">
									<span class="md-body-1">{{ formatDateTime(internacionActual.fecha_inicio_sintomas) }} hs.</span>
								</div>
							</div>
							<div class="md-layout-item">
								<span class="md-body-1">Fecha de diagnóstico de Covid:</span>
								<div class="md-layout-item">
									<span class="md-body-1">{{ formatDateTime(internacionActual.fecha_diagnostico) }} hs.</span>
								</div>
							</div>
							<div class="md-layout-item">
								<span class="md-body-1">Fecha de internación:</span>
								<div class="md-layout-item">
									<span class="md-body-1">{{ formatDateTime(internacionActual.fecha_carga) }} hs.</span>
								</div>
							</div>
							<div class="md-layout-item">
								<span class="md-body-1">Sistema actual: {{ internacionActual.sistema }}</span>
							</div>
							<div class="md-layout-item">
								<span class="md-body-1">Sala: {{ internacionActual.sala }}</span>
							</div>
							<div class="md-layout-item">
								<span class="md-body-1">Cama: {{ internacionActual.cama }}</span>
							</div>
						
							<!-- <div>
								<md-button class="md-dense md-success">Nueva Internación</md-button>
							</div> -->

							<div>
								<md-button class="md-dense md-success" @click="mostrarAntecedentes = true">Internaciones previas</md-button>
							</div>

						</div>

						<div v-show="internacionActual" class="md-layout-item md-small-size-100 md-size-33">
							
							<span class="md-title">Otras acciones</span>

							<br><br>

							<span class="md-subheading">Cambiar de sistema</span>
							<div class="md-layout">

								<div class="md-layout-item md-small-size-40 md-size-40">
									<md-field>
											<label for="cambiarDeSistema">Seleccionar</label>
											<md-select name="cambiarDeSistema">              
													<md-option value="Piso Covid">Piso Covid</md-option>
													<md-option value="UTI">UTI</md-option>
													<md-option value="Hotel">Hotel</md-option>                                        
											</md-select>
									</md-field>
								</div>

								<div class="md-layout-item md-small-size-40 md-size-40">
									<md-button class="md-success" @click="cambiarDeSistema()">Aceptar</md-button>
								</div>
							</div>
							
							<div>
								<md-button class="md-dense md-success" @click="declararEgreso()">Declarar egreso</md-button>
							</div>

							<div>
								<md-button class="md-dense md-danger" @click="declararObito()">Declarar óbito</md-button>
							</div>

						</div>
									
						<div class="md-layout">

							<div class="md-layout-item md-small-size-100 md-size-100">
								
								<span class="md-title">Evoluciones</span>

								<vue-good-table
								:columns="columnas"
								:rows="evoluciones"
								:lineNumbers="true"
								:defaultSortBy="{field: 'id', type: 'asec'}"
								:globalSearch="false"
								:pagination-options="{
										enabled: true,
										mode: 'records',
										perPage: 10,
										perPageDropdown: [ 10 ],
										position: 'bottom',
										dropdownAllowAll: false,
										setCurrentPage: 1,
										nextLabel: 'siguiente',
										prevLabel: 'anterior',
										rowsPerPageLabel: 'Pacientes por tabla',
										ofLabel: 'de',
									}"
								:search-options="{ enabled: true, placeholder: 'Buscar' }"
								styleClass="vgt-table">
								<div slot="emptystate" class="has-text-centered">
									<h3 class="h3">No hay evoluciones</h3>
								</div>
								<template slot="table-row" slot-scope="props">
									<span v-if="props.column.field == 'acciones'">
									
										
									</span>
								</template>
								</vue-good-table>

							</div>							

						</div>
					</div>
				</md-card-content>
				
			</md-card>
		</form>
	</div>
</template>

<script>

import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table';

export default {
	components: {
    VueGoodTable,
  },
	props: ['pacienteId'],
  data() {
    return {
			paciente: {},
			internacionActual: {},
			mostrarAntecedentes: false,
			mostrarContacto: false,
			evoluciones: [ { id: '1', fecha: '20201001', sistema: 'Guardia' },
										 { id: '1', fecha: '20201001', sistema: 'Guardia' },
										 { id: '1', fecha: '20201001', sistema: 'Guardia' }],
			columnas: [
        {
          label: 'id',
          field: 'id',
          type: 'number',
          filterable: true,
				},
				 {
          label: 'Fecha',
          field: 'fecha',
          type: 'number',
          filterable: true,
				},
				{
          label: 'Sistema',
          field: 'sistema',
          type: 'string',
          filterable: true,
        },
        {
          label: 'Acciones',
          field: 'acciones',
        },
      ],
    }
  },
  created() {
		this.getPaciente()    
  },
  methods: {
		async getPaciente() {
			let loading = this.$loading.show()
			try {
				const paciente = await axios.get(this.burl('/api/paciente/getPaciente?id=' + this.pacienteId))
				const internacion = await axios.get(this.burl('/api/internacion/vigente?pacienteId=' + this.pacienteId))
				this.paciente = paciente.data
				this.internacionActual = internacion.data
			} catch (error) {
				console.log(error)
			}
			loading.hide()
		},
		declararEgreso() {
			this.cambiarEstado('egreso')
		},
		declararObito() {
			this.cambiarEstado('obito')
		},
		cambiarEstado(estado) {
			this.$swal.fire({
				title: 'Está seguro?',
				text: "Esta acción es irreversible",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#F33527',
				cancelButtonColor: '#47A44B',
				confirmButtonText: 'Sí, declarar ' + (estado == 'obito' ? 'óbito' : 'egreso'),
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed) {
					let loading = this.$loading.show()
					axios.get(this.burl('/api/internacion/' + estado + '?id=' + this.internacionActual.id))
					.then(response => {
						if (response.status == 200) {
							this.$router.push('/pacientes')
						} else {
							this.$swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Se produjo un error',
								cancelButtonColor: '#47A44B'
							})
						}
						console.log(response.status)
					})
					loading.hide()
				}
			})
		}
  }
}

</script>