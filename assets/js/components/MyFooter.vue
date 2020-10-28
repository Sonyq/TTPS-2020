<template>
  <v-card height="150">
    <v-footer
      absolute
      class="font-weight-medium"
    >
      <v-col
        class="text-center"
        cols="12"
      >
        <!-- {{ new Date().getFullYear() }} — <strong>Vuetify</strong> -->
      </v-col>
    </v-footer>
  </v-card>
</template>

<script>
  export default {
    data() {
      return {
        isLoading: true
      }
    },
    mounted() {
      events.$on('loading_config:finish', () => this.isLoading = false)
    },
  }
</script>