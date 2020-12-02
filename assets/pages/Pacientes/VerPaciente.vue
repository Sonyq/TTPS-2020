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

              <!-- <md-button
                class="md-fab md-success md-icon-button"
                :to="{
                  name: 'Editar Paciente',
                  params: { pacienteId: pacienteId }
                }"
                ><md-icon>edit</md-icon>
              </md-button> -->

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
                <span class="md-body-1"
                  >Dirección: {{ paciente.direccion }}</span
                >
              </div>

              <div class="md-layout-item">
                <span class="md-body-1">Teléfono: {{ paciente.telefono }}</span>
              </div>

              <div class="md-layout-item">
                <span class="md-body-1">Email: {{ paciente.email }}</span>
              </div>

              <div class="md-layout-item">
                <span class="md-body-1"
                  >Fecha de nacimiento:
                  {{ formatDate(paciente.fecha_nacimiento) }}</span
                >
              </div>

              <div class="md-layout-item">
                <span class="md-body-1"
                  >Obra Social: {{ paciente.obra_social }}</span
                >
              </div>

              <div>
                <md-dialog :md-active.sync="mostrarAntecedentes">
                  <md-dialog-title>Antecedentes</md-dialog-title>

                  <md-dialog-content>
                    <span v-if="paciente.antecedentes" class="md-body">{{
                      paciente.antecedentes
                    }}</span>
                    <span v-else class="md-body">Sin antecedentes</span>
                  </md-dialog-content>

                  <md-dialog-actions>
                    <md-button
                      class="md-success"
                      @click="mostrarAntecedentes = false"
                      >Cerrar</md-button
                    >
                  </md-dialog-actions>
                </md-dialog>
              </div>

              <md-button
                class="md-dense md-success"
                @click="mostrarAntecedentes = true"
                >Ver Antecedentes</md-button
              >

              <div>
                <md-dialog :md-active.sync="mostrarContacto">
                  <md-dialog-title>Datos de algún contacto</md-dialog-title>

                  <md-dialog-content>
                    <div class="md-layout-item">
                      <span class="md-body-1"
                        >Nombre: {{ paciente.contacto_nombre }}</span
                      >
                    </div>

                    <div class="md-layout-item">
                      <span class="md-body-1"
                        >Apellido: {{ paciente.contacto_apellido }}</span
                      >
                    </div>

                    <div class="md-layout-item">
                      <span class="md-body-1"
                        >Teléfono: {{ paciente.contacto_telefono }}</span
                      >
                    </div>

                    <div class="md-layout-item">
                      <span class="md-body-1"
                        >Dirección: {{ paciente.contacto_relacion }}</span
                      >
                    </div>
                  </md-dialog-content>

                  <md-dialog-actions>
                    <md-button
                      class="md-success"
                      @click="mostrarContacto = false"
                      >Cerrar</md-button
                    >
                  </md-dialog-actions>
                </md-dialog>
              </div>

              <md-button
                class="md-dense md-success"
                @click="mostrarContacto = true"
                >Ver datos de algún contacto</md-button
              >

              <md-button
                class="md-dense md-success"
                :to="{
                  name: 'Paciente',
                  params: { pacienteId: pacienteId }
                }"
                >Editar Paciente
              </md-button>

            </div>

            <div class="md-layout-item md-small-size-100 md-size-33">
              <span class="md-title">Internación</span>

              <div
                v-show="
                  !(
                    ultimaInternacion.fecha_egreso ||
                    ultimaInternacion.fecha_obito
                  )
                "
              >
                <div class="md-layout-item">
                  <span class="md-body-1">Fecha de inicio de síntomas:</span>
                  <div class="md-layout-item">
                    <span class="md-body-1"
                      >{{
                        formatDateTime(ultimaInternacion.fecha_inicio_sintomas)
                      }}
                      hs.</span
                    >
                  </div>
                </div>
                <div class="md-layout-item">
                  <span class="md-body-1">Fecha de diagnóstico de Covid:</span>
                  <div class="md-layout-item">
                    <span class="md-body-1"
                      >{{
                        formatDateTime(ultimaInternacion.fecha_diagnostico)
                      }}
                      hs.</span
                    >
                  </div>
                </div>
                <div class="md-layout-item">
                  <span class="md-body-1">Fecha de internación:</span>
                  <div class="md-layout-item">
                    <span class="md-body-1"
                      >{{
                        formatDateTime(ultimaInternacion.fecha_carga)
                      }}
                      hs.</span
                    >
                  </div>
                </div>
                <div class="md-layout-item">
                  <span class="md-body-1"
                    >Sistema actual: {{ ultimaInternacion.sistema }}</span
                  >
                </div>
                <div class="md-layout-item">
                  <span class="md-body-1"
                    >Sala: {{ ultimaInternacion.sala }}</span
                  >
                </div>
                <div class="md-layout-item">
                  <span class="md-body-1"
                    >Cama: {{ ultimaInternacion.cama }}</span
                  >
                </div>
              </div>

              <div v-show="ultimaInternacion.fecha_obito">
                <span class="md-body-1">El paciente falleció.</span>
                <div class="md-layout">
                  <span class="md-body-1"
                    >Fecha de óbito:
                    {{ formatDateTime(ultimaInternacion.fecha_obito) }}
                    hs.</span
                  >
                </div>
              </div>

              <div v-show="ultimaInternacion.fecha_egreso">
                <span class="md-body-1"
                  >No posee ninguna internación vigente</span
                >
              </div>

              <div>
                <md-dialog :md-active.sync="mostrarPrevias">
                  <md-dialog-title>Internaciones previas</md-dialog-title>

                  <md-dialog-content>
                    <md-table
                      md-card
                      v-if="internacionesPrevias.length > 0"
                      class="md-body"
                    >
                      <md-table-row>
                        <md-table-head>Fecha ingreso</md-table-head>
                        <md-table-head>Fecha egreso</md-table-head>
                        <md-table-head>Fecha óbito</md-table-head>
                      </md-table-row>

                      <md-table-row
                        v-for="internacion in internacionesPrevias"
                        :key="internacion.id"
                      >
                        <md-table-cell
                          >{{
                            formatDateTime(internacion.fecha_carga)
                          }}.hs</md-table-cell
                        >

                        <md-table-cell v-if="internacion.fecha_egreso"
                          >{{
                            formatDateTime(internacion.fecha_egreso)
                          }}.hs</md-table-cell
                        >
                        <md-table-cell v-else></md-table-cell>
                        <md-table-cell v-if="internacion.fecha_obito"
                          >{{
                            formatDateTime(internacion.fecha_obito)
                          }}.hs</md-table-cell
                        >
                      </md-table-row>
                    </md-table>
                    <span v-else class="md-body"
                      >Sin internaciones previas</span
                    >
                  </md-dialog-content>

                  <md-dialog-actions>
                    <md-button
                      class="md-success"
                      @click="mostrarPrevias = false"
                      >Cerrar</md-button
                    >
                  </md-dialog-actions>
                </md-dialog>
              </div>

              <div>
                <md-button
                  class="md-dense md-success"
                  @click="getInternacionesPrevias()"
                  >Internaciones previas</md-button
                >
              </div>

              <div
                v-show="
                  ultimaInternacion.fecha_egreso &&
                    !ultimaInternacion.fecha_obito
                "
              >
                <md-button class="md-dense md-success"
                  >Nueva Internación</md-button
                >
              </div>
            </div>

            <div
              v-show="
                !(
                  ultimaInternacion.fecha_egreso ||
                  ultimaInternacion.fecha_obito
                ) && ultimaInternacion.sistema == loggedUser.sistemaNombre
              "
              class="md-layout-item md-small-size-100 md-size-33"
            >
              <span class="md-title">Otras acciones</span>

              <br /><br />

              <span class="md-subheading">Cambiar de sistema</span>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-40 md-size-40">
                  <md-field>
                    <label for="cambiarDeSistema">Seleccionar</label>
                    <md-select
                      v-model="sistemaDestinoSelected"
                      name="sistemaDestino"
                    >
                      <md-option
                        v-for="sistema in sistemasDestino"
                        :key="sistema.id"
                        :value="sistema.id"
                      >
                        {{ sistema.descrip }}
                      </md-option>
                    </md-select>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-40 md-size-40">
                  <md-button class="md-success" @click="cambiarDeSistema()"
                    >Aceptar</md-button
                  >
                </div>
              </div>

              <div>
                <md-button class="md-dense md-success" @click="declararEgreso()"
                  >Declarar egreso</md-button
                >
              </div>

              <div>
                <md-button class="md-dense md-danger" @click="declararObito()"
                  >Declarar óbito</md-button
                >
              </div>
            </div>

            <div
              v-show="
                !(
                  ultimaInternacion.fecha_egreso ||
                  ultimaInternacion.fecha_obito
                ) && ultimaInternacion.sistema == loggedUser.sistemaNombre
              "
              class="md-layout"
            >
              <div class="md-layout-item md-small-size-100 md-size-100">
                <span class="md-title">Evoluciones</span>

                <vue-good-table
                  :columns="columnas"
                  :rows="evoluciones"
                  :lineNumbers="true"
                  :globalSearch="false"
                  :pagination-options="{
                    enabled: true,
                    mode: 'records',
                    perPage: 5,
                    perPageDropdown: [5, 10],
                    position: 'bottom',
                    dropdownAllowAll: false,
                    setCurrentPage: 1,
                    nextLabel: 'siguiente',
                    prevLabel: 'anterior',
                    rowsPerPageLabel: 'Evoluciones por página',
                    ofLabel: 'de'
                  }"
                  :search-options="{ enabled: true, placeholder: 'Buscar' }"
                  styleClass="vgt-table"
                >
                  <div slot="emptystate" class="has-text-centered">
                    <h3 class="h3">No hay evoluciones</h3>
                  </div>
                  <div v-if="ultimaInternacion" slot="table-actions">
                    <md-button
                      :to="{
                        name: 'Nueva Evolución',
                        params: {
                          internacionId: ultimaInternacion.id,
                          pacienteId: pacienteId
                        }
                      }"
                      class="md-dense md-success"
                      >Nueva evolución</md-button
                    >
                  </div>
                  <!-- <template slot="table-row" slot-scope="props">
									<span v-if="props.column.field == 'acciones'">
									
									</span>
								</template> -->
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
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";

export default {
  name: 'IconButtons',
  components: {
    VueGoodTable
  },
  props: ["pacienteId"],
  data() {
    return {
      paciente: {},
      ultimaInternacion: "",
      internacionesPrevias: [],
      mostrarAntecedentes: false,
      mostrarContacto: false,
      mostrarPrevias: false,
      evoluciones: [],
      sistemasDestino: [],
      sistemaDestinoSelected: "",
      columnas: [
        {
          label: "id",
          field: "id",
          type: "number",
          filterable: true
        },
        {
          label: "Fecha de carga",
          field: this.fechaCargaEvolucion,
          type: "number",
          filterable: true
        },
        {
          label: "Sistema",
          field: "sistema",
          type: "string",
          filterable: true
        }
        // {
        //   label: 'Acciones',
        //   field: 'acciones',
        // },
      ]
    };
  },
  created() {
    this.getPaciente();
    this.getUltimaInternacionYEvoluciones();
    this.getSistemasDestino();
  },
  methods: {
    async getPaciente() {
      axios
        .get(this.burl("/api/paciente/getPaciente?id=" + this.pacienteId))
        .then(response => {
          this.paciente = response.data;
        });
    },
    async getUltimaInternacionYEvoluciones() {
      events.$emit("loading:show");
      const ultimaInternacion = await axios.get(
        this.burl("/api/internacion/ultima?pacienteId=" + this.pacienteId)
      );
      this.ultimaInternacion = ultimaInternacion.data;
      if (this.ultimaInternacion) {
        const evoluciones = await axios.get(
          this.burl("/api/evolucion/index?id=" + this.ultimaInternacion.id)
        );
        this.evoluciones = evoluciones.data;
      }
      events.$emit("loading:hide");
    },
    async getInternacionesPrevias() {
      events.$emit("loading:show");
      const internaciones = await axios.get(
        this.burl("/api/internacion/previas?pacienteId=" + this.pacienteId)
      );
      this.internacionesPrevias = internaciones.data;
      //si hay una internación vigente, a las previas le quito la 1ra (porque es la actual...)
      if (
        !(
          this.ultimaInternacion.fecha_obito ||
          this.ultimaInternacion.fecha_egreso
        )
      ) {
        this.internacionesPrevias.shift();
      }
      this.mostrarPrevias = true;
      events.$emit("loading:hide");
    },
    async getSistemasDestino() {
      const response = await axios.get(
        this.burl("/api/sistemas/sistemasDestino")
      );
      this.sistemasDestino = response.data;
    },
    declararEgreso() {
      this.cambiarEstado("egreso");
    },
    declararObito() {
      this.cambiarEstado("obito");
    },
    cambiarEstado(estado) {
      this.$swal
        .fire({
          title: "Está seguro?",
          text: "Esta acción es irreversible",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#F33527",
          cancelButtonColor: "#47A44B",
          confirmButtonText:
            "Sí, declarar " + (estado == "obito" ? "óbito" : "egreso"),
          cancelButtonText: "Cancelar"
        })
        .then(result => {
          if (result.isConfirmed) {
            events.$emit("loading:show");
            axios
              .get(
                this.burl(
                  "/api/internacion/" +
                    estado +
                    "?id=" +
                    this.ultimaInternacion.id
                )
              )
              .then(response => {
                this.$router.push("/pacientes");
              });
            events.$emit("loading:hide");
          }
        });
    },
    cambiarDeSistema() {
      this.$swal
        .fire({
          title: "Está seguro?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#F33527",
          cancelButtonColor: "#47A44B",
          confirmButtonText: "Sí, cambiar",
          cancelButtonText: "Cancelar"
        })
        .then(result => {
          if (result.isConfirmed) {
            events.$emit("loading:show");
            let form = {
              sistemaDestinoId: this.sistemaDestinoSelected,
              pacienteId: this.pacienteId,
              internacionId: this.ultimaInternacion.id
            };
            axios
              .post(this.burl("/api/sistemas/cambiar"), form)
              .then(response => {
                this.$router.push("/pacientes");
              });
            events.$emit("loading:hide");
          }
        });
    },
    fechaCargaEvolucion(evolucion) {
      return this.formatDateTime(evolucion.fecha_carga);
    }
  }
};
</script>
