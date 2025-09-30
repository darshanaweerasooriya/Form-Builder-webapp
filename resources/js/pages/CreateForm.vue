<script setup lang="ts">
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
  title: '',
  fields: [] as any[]
})

const addField = (type: string) => {
  form.fields.push({
    type,
    label: `${type} Field`,
    options: type === 'checkbox' || type === 'radio' ? ['Option 1', 'Option 2'] : [],
    required: false
  })
}

const saveForm = () => {
  router.post('/forms', form)
}

const removeField = (index: number) => {
  form.fields.splice(index, 1)
}
</script>

<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Create Form</h1>

    <div class="mb-4">
      <label class="block font-semibold mb-1">Form Title *</label>
      <input v-model="form.title" type="text" class="w-full border rounded p-2" placeholder="Enter form title" />
    </div>

    <!-- Add Field Buttons -->
    <div class="flex gap-2 mb-6">
      <button @click="addField('text')" class="bg-blue-100 px-3 py-1 rounded">+ Text Input</button>
      <button @click="addField('textarea')" class="bg-blue-100 px-3 py-1 rounded">+ Text Area</button>
      <button @click="addField('radio')" class="bg-blue-100 px-3 py-1 rounded">+ Radio Button</button>
      <button @click="addField('checkbox')" class="bg-blue-100 px-3 py-1 rounded">+ Checkbox</button>
    </div>

    <!-- Render Fields -->
    <div v-for="(field, index) in form.fields" :key="index" class="border rounded-lg p-4 mb-4">
      <div class="flex justify-between">
        <h3 class="font-semibold capitalize">{{ field.type }} Field</h3>
        <button @click="removeField(index)" class="text-red-500">Delete</button>
      </div>

      <div class="mt-2">
        <label class="block text-sm">Label</label>
        <input v-model="field.label" class="w-full border rounded p-2" />
      </div>

      <!-- Options for Radio/Checkbox -->
      <div v-if="field.type === 'checkbox' || field.type === 'radio'" class="mt-2">
        <label class="block text-sm">Options</label>
        <div v-for="(option, optIndex) in field.options" :key="optIndex" class="flex gap-2 mb-2">
          <input v-model="field.options[optIndex]" class="border rounded p-1 flex-1" />
          <button @click="field.options.splice(optIndex,1)" class="text-red-500">✖</button>
        </div>
        <button @click="field.options.push('New Option')" class="text-blue-600">+ Add Option</button>
      </div>

      <div class="mt-2">
        <label class="flex items-center gap-2">
          <input type="checkbox" v-model="field.required" />
          Required field
        </label>
      </div>
    </div>

    <!-- Save -->
    <div class="mt-6 flex gap-4">
      <button @click="saveForm" class="bg-blue-600 text-white px-4 py-2 rounded">Save Form</button>
      <button @click="router.get('/forms')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
    </div>
  </div>
</template>
