<template>
  <div>
    <NavBar />
    <router-view />  <!-- Vue Router affichera la bonne page ici -->
  </div>
</template>

<script>
import NavBar from './components/NavBar.vue';

export default {
  components: {
    NavBar
  }
};
</script>
