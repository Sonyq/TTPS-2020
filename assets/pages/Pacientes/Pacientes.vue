<template>

    <v-container fluid>
      
    </v-container>
    
</template>

<script>

export default {
  data() {
    return {
      isLoading: true,
      pacientes: []
    }
  },
  created() {
    this.getPacientes()
  },
  methods: {
    async getPacientes() {
      const pacientes = await axios.get(this.burl('/api/paciente/index'))
      console.log(pacientes)
      this.pacientes = pacientes.data
    }
  }
}

</script>
