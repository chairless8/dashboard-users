<template>
  <div>
    <v-img
      class="mx-auto my-6"
      max-width="228"
      src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
    ></v-img>

    <v-card
      class="mx-auto pa-12 pb-8"
      elevation="8"
      max-width="448"
      rounded="lg"
    >
      <div class="text-subtitle-1 text-medium-emphasis">Register</div>

      <span>Username</span>
      <v-text-field
        v-model="name"
        density="compact"
        placeholder="Full Name"
        prepend-inner-icon="mdi-account-outline"
        variant="outlined"
        :error="errors.name.length > 0"
        :error-messages="errors.name"
      ></v-text-field>

      <span>Email</span>
      <v-text-field
        v-model="email"
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
        :error="errors.email.length > 0"
        :error-messages="errors.email"
      ></v-text-field>

      <span>Password</span>
      <v-text-field
        v-model="password"
        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Enter your password"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
        :error="errors.password.length > 0"
        :error-messages="errors.password"
      ></v-text-field>

      <span>Password Confirmation</span>
      <v-text-field
        v-model="passwordConfirmation"
        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Confirm your password"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
        :error="errors.password_confirmation.length > 0"
        :error-messages="errors.password_confirmation"
      ></v-text-field>

      <v-btn
        class="mb-8"
        color="blue"
        size="large"
        variant="tonal"
        block
        @click="register"
      >
        Sign Up
      </v-btn>
    </v-card>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const visible = ref(false);
const errors = ref({
  name: [] as string[],
  email: [] as string[],
  password: [] as string[],
  password_confirmation: [] as string[],
});
const router = useRouter();

const register = async () => {
  errors.value = {
    name: [],
    email: [],
    password: [],
    password_confirmation: [],
  };

  try {
    const response = await axios.post('http://localhost:8000/api/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value,
    });

    localStorage.setItem('token', response.data.token);
    router.push({ name: 'dashboard' });
  } catch (error: any) {
    if (error.response?.status === 422 && error.response?.data) {
      const validationErrors = error.response.data;
      for (const key in validationErrors) {
        if (validationErrors.hasOwnProperty(key)) {
          errors.value[key] = validationErrors[key];
        }
      }
    } else {
      console.error('Registration failed:', error.response?.data || error.message);
    }
  }
};

const goToRegister = () => {
  router.push({ name: 'register' });
};
</script>

<style scoped>
.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.my-6 {
  margin-top: 1.5rem;
  margin-bottom: 1.5rem;
}

.pa-12 {
  padding: 3rem;
}

.pb-8 {
  padding-bottom: 2rem;
}

.mb-8 {
  margin-bottom: 2rem;
}

.text-medium-emphasis {
  color: rgba(0, 0, 0, 0.6);
}

.text-blue {
  color: #1e88e5;
}
</style>
