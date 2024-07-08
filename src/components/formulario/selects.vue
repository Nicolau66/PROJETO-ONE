<template>
    <div>
      <label :for="id" class="sr-only">{{ label }}</label>
      <select :id="id" :name="name" class="custom-select">
        <option v-for="option in options" :key="option.value" :value="option.value">{{ option.text }}</option>
      </select>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      id: String,
      name: String,
      label: String,
      options: Array,
    }
  }
  </script>
  
  <style>
  .custom-select {
    @apply block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200;
  }
  </style>
  