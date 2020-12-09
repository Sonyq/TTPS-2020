<template>
  <div></div>
</template>

<script>
export default {
  data() {
    return {};
  },
  created() {
    this.logout();
  },
  methods: {
    logout(recursive = false) {
      if (!recursive) {
        events.$emit("user:logout");
      }
      axios.defaults.headers.common["Authorization"] = null;
      localStorage.removeItem("token");
      this.jwtToken.clear;
      this.loggedUser.clear;
      this.$router.push("/");
    }
  }
};
</script>
