<template>

    <p>home test</p>

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
