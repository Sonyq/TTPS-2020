<template>
  <div>

    <div class="content">

      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
      
      <div>

        <router-link to="/pacientes/nuevo">
          <md-button class="md-info">Agregar Paciente</md-button>
        </router-link>

      </div>      

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
          <h3 class="h3">No hay pacientes para mostrar</h3>
        </div>
        <!-- <div slot="table-actions">
          <md-button class="md-info" @click="showAddPatientModal(null, 'Agregar Paciente')">Agregar Paciente</md-button>
        </div> -->
        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'acciones'">
            <!-- <button v-if="loggedUser.permisos.includes('paciente_update')" type="button" class="button is-info is-small button-is-spaced" title="Editar" @click="showAddPatientModal(props.row, 'Editar Paciente')">Editar</button>
            <button v-if="loggedUser.permisos.includes('paciente_show')" type="button" class="button is-info is-small button-is-spaced" title="Ver" @click="showViewPatientModal(props.row)">Ver</button>
            <button v-if="loggedUser.permisos.includes('paciente_destroy')" class="button_delete button is-danger is-small button-is-spaced" title="Eliminar" @click="deletePatient(props.row.id)">Eliminar</button> -->
            <!-- <router-link
            v-if="loggedUser.permisos.includes('atencion_index')"
            class="button is-info is-small button-is-spaced"
            :to="{ name: 'consulta', params: { idPaciente: props.row.id}}"
            title="Atenciones"
            replace>
              Atenciones
            </router-link> -->
          </span>
        </template>
      </vue-good-table>
    </div>
    </div>     
  </div>   
</template>

<script>

import 'vue-good-table/dist/vue-good-table.css'
import { VueGoodTable } from 'vue-good-table';

export default {
  components: {
    VueGoodTable,
  },
  data() {
    return {
      pacientes: [],
      columnas: [
        {
          label: 'Dni',
          field: this.getDni,
          type: 'number',
          filterable: true,
          width: '80px'
        },
        {
          label: 'Apellido',
          field: this.getApellido,
        },
        {
          label: 'Nombre',
          field: this.getNombre
        },
        {
          label: 'Sistema',
          field: this.getSistema
        },
        {
          label: 'Sala',
          field: this.getSala
        },
        {
          label: 'Cama',
          field: this.getCama,
          type: 'number',
          width: '80px'
        },
        {
          label: 'Estado',
          field: this.getEstado,
          width: '80px'
        },
        {
          label: 'Acciones',
          field: 'acciones',
        },
      ],
    }
  },
  created() {
    this.getPacientes()
  },
  methods: {
    async getPacientes() {
      let loader = this.$loading.show()
      let sistema = this.$route.params.id ? '?sistema=' + this.$route.params.id : ''
      const pacientes = await axios.get(this.burl('/api/paciente/index' + sistema))
      this.pacientes = pacientes.data
      loader.hide();
    },
    getDni(paciente) {
      return paciente.dni
    },
    getApellido(paciente) {
      return paciente.apellido
    },
    getNombre(paciente) {
      return paciente.nombre
    },
    getSistema(paciente) {
      return paciente.sistema
    },
    getSala(paciente) {
      return paciente.sala
    },
    getCama(paciente) {
      return paciente.cama
    },
    getEstado(paciente) {
      if (paciente.fecha_egreso) {
        return 'Egresado'
      } else if (paciente.fecha_obito) {
        return 'Fallecido'
      } else {
        return 'Internado'
      }
    }
  },
}

</script>

<style>

.vgt-input, .vgt-select {
  width: 50%;
}

.vgt-global-search, .vgt-table thead th, .vgt-table th.line-numbers, .vgt-table th.vgt-checkbox-col {
  background: linear-gradient(#EEEEEE,#EEEEEE);
  color: #4BA64F;
  border-right: none;
  border-bottom: 1px solid #EEEEEE;
}

table.vgt-table {
    font-size: 14px;
    border-collapse: collapse;
    background-color: #fff;
    table-layout: auto;
    border: 1px solid #EEEEEE;
}

.vgt-global-search {
  padding: 10px 0;
  border: 1px solid #EEEEEE;
}

.vgt-wrap__footer {
  color: #EEEEEE;
  padding: 1em;
  border: 1px solid #EEEEEE;
  background: linear-gradient(#EEEEEE,#EEEEEE);
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
  
</style>
