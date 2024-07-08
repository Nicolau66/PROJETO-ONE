<template>
    <div class="input-group">
      <!-- Adicionado a classe 'peer' diretamente aqui -->
      <input :type="type" :name="name" :id="id" class="input-field peer" :placeholder="placeholder" required />
      <label :for="id" class="input-label">{{ label }}</label>
    </div>
</template>

<script>
export default {
    props: {
      type: String,
      name: String,
      id: String,
      label: String,
      placeholder: String
    }
}
</script>

<style>
.input-group {
    @apply relative z-0 w-full mb-5;
}
.input-field {
    @apply block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-sky-500 focus:outline-none focus:ring-0 focus:border-sky-600;
}
.input-label {
    @apply absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:font-medium peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-sky-600 peer-focus:dark:text-sky-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6;
}
</style>
