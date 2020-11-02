<template>

   
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
      this.pacientes = pacientes.data
    }
  }
}

</script>
