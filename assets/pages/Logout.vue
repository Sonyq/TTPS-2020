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
      events.$emit("loading:show");
      if (!recursive) {
        events.$emit("user:logout");
      }
      axios.defaults.headers.common["Authorization"] = null;
      localStorage.removeItem("token");
      this.jwtToken.clear;
      this.loggedUser.clear;
      events.$emit("loading:hide");
      this.$router.push("/");
    }
  }
};
</script>
