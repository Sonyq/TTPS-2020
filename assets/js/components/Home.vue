<template>

    <v-container fluid>
      <v-row dense>
        <v-col
          v-for="card in cards"
          :key="card.title"
          :cols="card.flex"
        >
          <v-card>
            <!-- <v-img
              :src="card.src"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="200px"
            > -->
              <v-card-title v-text="card.title"></v-card-title>
            <!-- </v-img> -->

            <v-card-text class="text--primary">
              <div>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</div>
            </v-card-text>

          </v-card>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>

export default {
  data() {
    return {
      isLoading: true,
      cards: [
        { title: 'Título 1', flex: 4 },
        { title: 'Título 2', flex: 4 },
        { title: 'Título 3', flex: 4 },
        { title: 'Título 4', flex: 4 },
        { title: 'Título 4', flex: 4 },
        { title: 'Título 4', flex: 4 },
      ],
    }
  },
  mounted() {
    events.$on('loading_config:finish', () => this.isLoading = false)
  },
}

</script>
