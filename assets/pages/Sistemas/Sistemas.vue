<template>
  <div>

    <loading :active.sync="isLoading"
              :is-full-page="true"
              color='#4CAF50'>
    </loading>

    <div class="content">
      <div class="md-layout">

        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
          <stats-card data-background-color="green">
            <template slot="header">
              <md-icon>local_hospital</md-icon>
            </template>

            <template slot="content">
              <h3 class="title">Guardia</h3>
              <p class="category">Camas totales: 50</p>
              <p class="category">Camas ocupadas: 25</p>
              <p class="category">Camas disponibles: 25</p>
            </template>

          </stats-card>
        </div>

        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
          <stats-card data-background-color="green">
            <template slot="header">
              <md-icon>healing</md-icon>
            </template>

            <template slot="content">
              <h3 class="title">Piso Covid</h3>
              <p class="category">Camas totales: 50</p>
              <p class="category">Camas ocupadas: 25</p>
              <p class="category">Camas disponibles: 25</p>
            </template>

          </stats-card>
        </div>

        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
          <stats-card data-background-color="red">
            <template slot="header">
              <md-icon>add_alert</md-icon>
            </template>

            <template slot="content">
              <h3 class="title">UTI</h3>
              <p class="category">Camas totales: 50</p>
              <p class="category">Camas ocupadas: 25</p>
              <p class="category">Camas disponibles: 25</p>
            </template>

          </stats-card>
        </div>

        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
          <stats-card data-background-color="green">
            <template slot="header">
              <md-icon>hotel</md-icon>
            </template>

            <template slot="content">
              <h3 class="title">Hotel</h3>
              <p class="category">Camas totales: 50</p>
              <p class="category">Camas ocupadas: 25</p>
              <p class="category">Camas disponibles: 25</p>
            </template>

          </stats-card>
        </div>

        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
          <stats-card data-background-color="green">
            <template slot="header">
              <md-icon>home</md-icon>
            </template>

            <template slot="content">
              <h3 class="title">Domicilio</h3>
            </template>

          </stats-card>
        </div>

      </div>
    </div>
  </div>
</template>

<script>

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import StatsCard from '../../components/Cards/StatsCard.vue';

export default {
  components: {
    Loading,
    StatsCard
  },
  data() {
    return {
      isLoading: false,
      sistemas: []
    }
  },
  created() {
    // this.getSistemas()
  },
  methods: {
    async getSistemas() {
      const sistemas = await axios.get(this.burl('/api/sistemas/index'))
      this.sistemas = sistemas.data
      this.isLoading = false
    }
  },
}

</script>