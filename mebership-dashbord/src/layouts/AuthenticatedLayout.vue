<template>
  <v-app>
    <v-navigation-drawer app v-model="drawer">
      <v-card class="mx-auto mt-6" max-width="300">
        <v-card-title class="text-h6">
          Welcome, {{ user.name }}!
        </v-card-title>
        <v-card-subtitle class="pb-2">
          {{ user.email }}
        </v-card-subtitle>
        <v-divider></v-divider>
        <v-list>
          <v-list-item @click="goDashboard">
              <span>
                Dashboard
              </span>
          </v-list-item>
          <v-list-item @click="myProfile">
            <span>
              My Profile
            </span>
          </v-list-item>
          <v-list-item @click="settings">
            <span>
              Settings
            </span>
          </v-list-item>
        </v-list>
      </v-card>
    </v-navigation-drawer>

    <v-app-bar app :clipped-left="display.lgAndUp">
      <v-app-bar-nav-icon @click="toggleDrawer" v-if="!display.lgAndUp.value"/>
      <h1>
        My app to !Company!
      </h1>
      <v-btn @click="logout" class="ml-auto" color="primary" variant="tonal">
        Log Out
      </v-btn>
    </v-app-bar>

    <v-main>
      <v-container>
        <router-view />
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useDisplay } from 'vuetify';
import axios from 'axios';
import { useRouter } from 'vue-router';

const display = useDisplay();
const drawer = ref(false);

function toggleDrawer() {
  drawer.value = !drawer.value;
}

const user = ref({
  name: '',
  email: ''
});

const router = useRouter();

const fetchUser = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/me', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
    user.value = response.data;
  } catch (error) {
    console.error('Failed to fetch user info:', error.response?.data || error.message);
    if (error.response?.status === 401) {
      router.push({ name: 'login' });
    }
  }
};

const goDashboard = () => {
  router.push({ name: 'dashboard' });
};

const myProfile = () => {
  router.push({ name: 'profile' });
};

const settings = () => {
  // Agregar lógica para configuración cuando sea necesario
};

const logout = () => {
  localStorage.removeItem('token');
  router.push({ name: 'login' });
};

onMounted(() => {
  fetchUser();
});
</script>

<style scoped>
.ml-auto {
  margin-left: auto;
  margin-inline-end: 25px !important;
}
</style>
