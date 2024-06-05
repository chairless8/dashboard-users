<template>
  <div>
    <h3>Your video list</h3>
    <div v-if="videos.length">
      <ul>
        <li v-for="video in videos" :key="video.id" class="video-item">
          <div v-if="editingVideoId === video.id" class="w-full">
            <v-text-field
              v-model="editedVideoTitle"
              label="Edit Title"
              dense
              @keyup.enter="updateVideo(video.id)"
            ></v-text-field>
            <v-btn @click="updateVideo(video.id)" color="green" small icon>
              <v-icon>mdi-check</v-icon>
            </v-btn>
          </div>
          <div class="w-full" v-else>
            <h4>
              {{ video.title }}
            </h4>
            <div class="actions">
              <v-btn @click="viewVideo(video.url)" color="blue" small icon class="custom-btn">
                <v-icon>mdi-eye</v-icon>
              </v-btn>
              <v-btn @click="startEditing(video)" color="orange" small icon class="custom-btn" >
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn @click="deleteVideo(video.id)" color="red" small icon class="custom-btn">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div v-else>
      <p>No videos found.</p>
    </div>
    <div class="mt-med">
      <h3>Add other video</h3>
      <v-form ref="form">
        <v-text-field
          v-model="newVideoTitle"
          label="Video Title"
          required
        ></v-text-field>
        <v-text-field
          v-model="newVideoUrl"
          label="Video URL"
          required
        ></v-text-field>
        <v-btn @click="addVideo">Add Video</v-btn>
      </v-form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios, { AxiosError } from 'axios';
import { useRouter } from 'vue-router';

const videos = ref([]);
const newVideoTitle = ref('');
const newVideoUrl = ref('');
const editedVideoTitle = ref('');
const editingVideoId = ref<number | null>(null);
const form = ref();
const router = useRouter();

const fetchVideos = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/videos', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
    videos.value = response.data;
  } catch (error) {
    const err = error as AxiosError;
    if (err.response) {
      console.error('Failed to fetch videos:', err.response.data);
    } else {
      console.error('Failed to fetch videos:', err.message);
    }
    if (err.response?.status === 401) {
      router.push({ name: 'login' });
    }
  }
};

const addVideo = async () => {
  if (!form.value.validate()) {
    return;
  }
  
  try {
    const response = await axios.post('http://localhost:8000/api/videos', {
      title: newVideoTitle.value,
      url: newVideoUrl.value,
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
    videos.value.push(response.data);
    newVideoTitle.value = '';
    newVideoUrl.value = '';
  } catch (error) {
    const err = error as AxiosError;
    if (err.response) {
      console.error('Failed to add video:', err.response.data);
    } else {
      console.error('Failed to add video:', err.message);
    }
  }
  fetchVideos();
};

const deleteVideo = async (id: number) => {
  try {
    await axios.delete(`http://localhost:8000/api/videos/${id}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
    videos.value = videos.value.filter(video => video.id !== id);
  } catch (error) {
    const err = error as AxiosError;
    if (err.response) {
      console.error('Failed to delete video:', err.response.data);
    } else {
      console.error('Failed to delete video:', err.message);
    }
  }
  fetchVideos();
};

const viewVideo = (url: string) => {
  window.open(url, '_blank');
};

const startEditing = (video: { id: number, title: string }) => {
  editingVideoId.value = video.id;
  editedVideoTitle.value = video.title;
};

const updateVideo = async (id: number) => {
  try {
    await axios.put(`http://localhost:8000/api/videos/${id}`, {
      title: editedVideoTitle.value,
    }, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });
    const video = videos.value.find(video => video.id === id);
    if (video) {
      video.title = editedVideoTitle.value;
    }
    editingVideoId.value = null;
    editedVideoTitle.value = '';
  } catch (error) {
    const err = error as AxiosError;
    if (err.response) {
      console.error('Failed to update video:', err.response.data);
    } else {
      console.error('Failed to update video:', err.message);
    }
  }
  fetchVideos();
};

onMounted(() => {
  fetchVideos();
});
</script>

<style scoped>
ul {
  list-style-type: none;
  padding: 0;
}
li {
  margin-bottom: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.actions {
  display: flex;
  gap: 8px;
}
.mt-med {
  margin-top: 150px;
}

.custom-btn{
  width: 38px;
  height: 38px;
}

.w-full{
  width: 100%;
}
</style>
