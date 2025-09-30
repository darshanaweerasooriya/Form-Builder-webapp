<script setup lang="ts">
import { router } from '@inertiajs/vue3'

interface Form {
  id: number
  title: string
  submissions: number
}

defineProps<{
  forms: Form[]
}>()

const editForm = (id: number) => {
  router.get(`/forms/${id}/edit`)
}

const previewForm = (id: number) => {
  router.get(`/forms/${id}`)
}

const deleteForm = (id: number) => {
  if (confirm("Are you sure you want to delete this form?")) {
    router.delete(`/forms/${id}`)
  }
}
</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Forms</h1>
      <button 
        @click="router.get('/forms/create')" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
      >
        + Create Form
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div v-for="form in forms" :key="form.id" class="border rounded-lg p-4 shadow-sm">
        <h2 class="font-semibold text-lg mb-4">{{ form.title }}</h2>
        <div class="flex gap-2">
          <button @click="editForm(form.id)" class="bg-blue-600 text-white px-3 py-1 rounded">Edit</button>
          <button @click="previewForm(form.id)" class="bg-gray-300 px-3 py-1 rounded">Preview</button>
          <span class="bg-indigo-100 text-indigo-600 px-3 py-1 rounded">{{ form.submissions }}</span>
          <button @click="deleteForm(form.id)" class="bg-red-500 text-white px-3 py-1 rounded">🗑</button>
        </div>
      </div>
    </div>
  </div>
</template>
