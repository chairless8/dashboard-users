<template>
  <v-container>
    <h1>Dashboard</h1>
    <p>Welcome to your Dashboard. Here you can manage your application's main features.</p>
    <video-list></video-list>
  </v-container>
</template>

<script setup lang="ts">
import VideoList from '@/components/VideoList.vue';

</script>

<style scoped>
h1 {
  margin-top: 20px;
  color: #2c3e50;
}
p {
  margin-top: 5px;
  font-size: 16px;
  color: #34495e;
}
</style>
