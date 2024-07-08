<template>
  <nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700" id="nav">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <img src="./assets/img/WhatsApp_Image_2023-06-12_at_10.42.23-removebg-preview.png" class="logo h-10" alt="Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"></span>

      <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
        <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
          <li>
            <RouterLink to="/" class="block py-2 px-3 md:p-0 text-white bg-sky-700 rounded md:bg-transparent md:text-sky-700 md:dark:text-sky-500 dark:bg-sky-600 md:dark:bg-transparent" aria-current="page">Banco de Dados</RouterLink>
          </li>
          <li>
            <RouterLink to="/index_dp_fiscal" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-sky-700 dark:text-white md:dark:hover:text-sky-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Departamento Fiscal</RouterLink>
          </li>
          <li>
            <RouterLink to="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-sky-700 dark:text-white md:dark:hover:text-sky-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Departamento Pessoal</RouterLink>
          </li>
          <li>
            <RouterLink to="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-sky-700 dark:text-white md:dark:hover:text-sky-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Tasks</RouterLink>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
    <RouterView />
  </main>
</template>

<style>
#nav {
  background-color: #161616;
}


#nav.bg-gray-800 {
  background-color: #000; 
}

body {
  background-color: rgb(27, 27, 27);

  background-size: cover; 
  background-repeat: no-repeat; 
  background-position: center center; 
}

main {
  display: flex;
  justify-content: center;
  max-width: auto;
  margin-top: 50px;
}

.logo {
  transform: scale(2.5); 
  align-self: center; 
  margin-right: 10px; 
  margin-left: 15px;
  pointer-events: none; 
}
</style>

<script>
export default {
  name: 'App'
}
</script>
