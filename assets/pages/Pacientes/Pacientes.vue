<template>
  <div>

    <md-card>
      <md-card-header v-if="user" data-background-color="green">
        <span class="md-title">Pacientes en {{ nombreSistema }}</span>
      </md-card-header>

      <md-card-content>

        <div class="md-layout">
        
          <div class="md-layout-item md-size-100 text-right">
      
            <router-link to="/nuevoPaciente">
              <md-button class="md-success">Agregar Paciente</md-button>
            </router-link>
        
          </div>
          
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">

            <vue-good-table
              :columns="columnas"
              :rows="pacientes"
              :lineNumbers="true"
              :defaultSortBy="{field: 'apellido', type: 'asec'}"
              :globalSearch="false"
              :pagination-options="{
                  enabled: true,
                  mode: 'records',
                  perPage: 10,
                  perPageDropdown: [ 10, 20 ],
                  position: 'bottom',
                  dropdownAllowAll: false,
                  setCurrentPage: 1,
                  nextLabel: 'siguiente',
                  prevLabel: 'anterior',
                  rowsPerPageLabel: 'Pacientes por página',
                  ofLabel: 'de',
                }"
              :search-options="{ enabled: true, placeholder: 'Buscar' }"
              styleClass="vgt-table">
              <div slot="emptystate" class="has-text-centered">
                <h3 class="h3">No hay pacientes para mostrar</h3>
              </div>
              <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'acciones'">
                  <!-- <button v-if="loggedUser.permisos.includes('paciente_update')" type="button" class="button is-info is-small button-is-spaced" title="Editar" @click="showAddPatientModal(props.row, 'Editar Paciente')">Editar</button>--> 

                  <md-menu md-direction="bottom-start">
                    <md-button class="md-success" style="height: 30px" md-menu-trigger>
                      <md-icon>menu</md-icon>
                    </md-button>

                    <md-menu-content>
                      <router-link :to="{ name: 'Ver Paciente', params: { pacienteId: props.row.id } }">
                        <md-menu-item>Ver</md-menu-item>
                      </router-link>
                      <md-menu-item>Asignar médico</md-menu-item>
                      <md-menu-item>Cambiar estado</md-menu-item>
                    </md-menu-content>
                  </md-menu>

                </span>
              </template>
            </vue-good-table>
          </div>
        </div>
      </md-card-content>		
		</md-card>
  </div>   
</template>

<script>

import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table';

export default {
  components: {
    VueGoodTable,
  },
  props: ['sistemaNombre', 'sistemaId'],
  data() {
    return {
      pacientes: [],
      user: '',
      columnas: [
        {
          label: 'Dni',
          field: 'dni',
          type: 'number',
          width: '80px',
        },
        {
          label: 'Apellido',
          field: 'apellido',
          width: '150px'
        },
        {
          label: 'Nombre',
          field: 'nombre',
          width: '150px'
        },
        {
          label: 'Sistema',
          field: 'sistema',
          width: '100px'
        },
        {
          label: 'Sala',
          field: 'sala',
          width: '100px'
        },
        {
          label: 'Cama',
          field: 'cama',
          type: 'number',
          width: '80px',
          filterable: false,
        },
        {
          label: 'Estado',
          field: this.getEstado,
          width: '80px'
        },
        {
          label: 'Acciones',
          field: 'acciones',
          width: '50px'
        },
      ],
    }
  },
  created () {
    this.getPacientes()
  },
  mounted() {
    events.$on('loading_user:finish', () => this.user = this.loggedUser )
  },
  methods: {
    async getPacientes() {
      events.$emit("loading:show")
      let sistemaId = this.sistemaId ? '?sistema=' + this.sistemaId : ''
      const pacientes = await axios.get(this.burl('/api/paciente/index' + sistemaId))
      this.pacientes = pacientes.data
      events.$emit("loading:hide")
    },
    getEstado(paciente) {
      if (paciente.fecha_egreso) {
        return 'Egresado'
      } else if (paciente.fecha_obito) {
        return 'Fallecido'
      } else {
        return 'Internado'
      }
    },
  },
  computed: {
    nombreSistema () {
      return this.sistemaNombre ? this.sistemaNombre : this.user.sistemaNombre 
    }
  }
}

</script>

<style>

.vgt-input, .vgt-select {
  width: 50%;
}

.vgt-global-search, .vgt-table thead th, .vgt-table th.line-numbers, .vgt-table th.vgt-checkbox-col {
  background: linear-gradient(#FFFFFF,#FFFFFF);
  color: #4BA64F;
  border-right: none;
  border-bottom: 1px solid #FFFFFF;
}

table.vgt-table {
  font-size: 14px;
  border-collapse: collapse;
  background-color: #FFFFFF;
  table-layout: auto;
  border: 1px solid #FFFFFF;
}

.vgt-global-search {
  padding: 10px 0;
  border: 1px solid #FFFFFF;
}

.vgt-wrap__footer {
  color: #FFFFFF;
  padding: 1em;
  border: 1px solid #FFFFFF;
  background: linear-gradient(#FFFFFF,#FFFFFF);
}

.vgt-wrap__footer .footer__navigation__page-btn {
  text-decoration: none;
  color: #606266;
  font-weight: 700;
  white-space: nowrap;
}

.vgt-table thead th.sorting-asc:after {
    border-bottom: 5px solid #4BA64F;
}

.vgt-table thead th.sorting-desc:before {
    border-top: 5px solid #4BA64F;
}

.vgt-right-align {
  text-align: left;
}

table.vgt-table td {
  padding: .50em .50em .50em .50em;
  vertical-align: middle; 
  border-bottom: 1px solid #dcdfe6;
  color: #606266;
}

.vgt-right-align {
  text-align: left;
}

.vgt-wrap__footer .footer__navigation__page-btn .chevron.right::after {
    border-left: 6px solid #4BA64F;
    margin-left: -3px;
}

.vgt-wrap__footer .footer__navigation__page-btn .chevron.left::after {
    border-right: 6px solid #4BA64F;
    margin-left: -3px;
}

</style>
