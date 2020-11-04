<template>
  <div>

    <div class="content">
      
      <div class="md-layout">

          <div v-for="sistema in sistemas" :key="sistema.id" class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
            
            <router-link :to="{ name: 'Pacientes', params: { sistemaNombre: sistema.descrip, sistemaId : sistema.id } }">

              <stats-card :data-background-color="sistema.nombre == 'UTI' ? 'red' : 'green'">
                <template slot="header">
                  <md-icon v-if="sistema.nombre == 'GUARDIA'">local_hospital</md-icon>
                  <md-icon v-if="sistema.nombre == 'PISOCOVID'">healing</md-icon>
                  <md-icon v-if="sistema.nombre == 'UTI'">add_alert</md-icon>
                  <md-icon v-if="sistema.nombre == 'HOTEL'">hotel</md-icon>
                  <md-icon v-if="sistema.nombre == 'DOMICILIO'">home</md-icon>
                </template>

                <template slot="content">
                  <h3 class="title">{{ sistema.descrip }}</h3>
                  <div v-if="sistema.nombre != 'DOMICILIO'">
                    <p class="category">Camas totales:{{ sistema.camas_total }}</p>
                    <p class="category">Camas ocupadas: {{ sistema.camas_disponibles }}</p>
                    <p class="category">Camas disponibles: {{ sistema.camas_ocupadas }}</p>
                  </div>
                </template>

              </stats-card>
            </router-link>
          </div>

      </div>
    </div>
  </div>
</template>

<script>

import StatsCard from '../../components/Cards/StatsCard.vue';

export default {
  components: {
    StatsCard
  },
  data() {
    return {
      sistemas: []
    }
  },
  created() {
    this.getSistemas()
  },
  methods: {
    async getSistemas() {
      let loader = this.$loading.show()
      const sistemas = await axios.get(this.burl('/api/sistemas/index'))
      this.sistemas = sistemas.data
      loader.hide();
    }
  },
}

</script>