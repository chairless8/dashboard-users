<template>
  <v-container>
    <h1>My Profile</h1>
    <v-card>
      <v-card-title>{{ user.name }}</v-card-title>
      <v-card-subtitle>{{ user.email }}</v-card-subtitle>
      <!-- Aquí puedes agregar más información del perfil -->
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const user = ref({ name: '', email: '' });
const router = useRouter();

const fetchProfile = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/me', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
    user.value = response.data;
  } catch (error) {
    console.error('Failed to fetch profile:', error.response?.data || error.message);
    if (error.response?.status === 401) {
      router.push({ name: 'login' });
    }
  }
};

onMounted(() => {
  fetchProfile();
});
</script>

<style scoped>
h1 {
  margin-top: 20px;
  color: #2c3e50;
}
</style>
