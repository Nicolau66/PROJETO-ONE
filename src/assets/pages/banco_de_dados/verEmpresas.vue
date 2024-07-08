<template>
  <div class="container mx-auto p-4">
    <div class="overflow-x-auto mt-6">
      <table class="min-w-full bg-gray-800 border border-gray-600 rounded-lg shadow-lg">
        <thead class="bg-gray-700 text-white uppercase text-sm leading-normal">
          <tr>
            <th class="py-3 px-6 text-left">ID da Empresa</th>
            <th class="py-3 px-6 text-left">Empresa</th>
            <th class="py-3 px-6 text-left">CNPJ</th>
            <th class="py-3 px-6 text-left">Telefone</th>
            <th class="py-3 px-6 text-center">Ações</th>
          </tr>
        </thead>
        <tbody class="text-gray-300 text-sm font-light">
          <tr v-for="empresa in empresas" :key="empresa.idEmpresa" class="border-b border-gray-700 hover:bg-gray-700 transition duration-300 ease-in-out">
            <td class="py-3 px-6 text-left">{{ empresa.idEmpresa }}</td>
            <td class="py-3 px-6 text-left">{{ empresa.razaoSocial }}</td>
            <td class="py-3 px-6 text-left">{{ empresa.cnpj }}</td>
            <td class="py-3 px-6 text-left">{{ empresa.telefone }}</td>
            <td class="py-3 px-6 text-center">
              <router-link :to="{ name: 'editEmpresa', params: { id: empresa.idEmpresa } }" class="text-blue-400 hover:text-blue-600 transition duration-300 ease-in-out transform hover:scale-105">Editar</router-link>
              <button @click="confirmDeleteEmpresa(empresa.idEmpresa)" class="text-red-400 hover:text-red-600 ml-2 transition duration-300 ease-in-out transform hover:scale-105">Remover</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

const apiUrl = import.meta.env.VITE_API_URL;

export default {
  data() {
    return {
      empresas: [],
    };
  },
  created() {
    this.fetchEmpresas();
  },
  methods: {
    fetchEmpresas() {
      axios.get(`${apiUrl}/backend/formulario/listarEmpresas.php`)
        .then(response => {
          this.empresas = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os dados:", error);
        });
    },
    confirmDeleteEmpresa(idEmpresa) {
      Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá desfazer esta ação!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, remover!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteEmpresa(idEmpresa);
        }
      });
    },
    deleteEmpresa(idEmpresa) {
      const formData = new FormData();
      formData.append('idEmpresa', idEmpresa);

      axios.post(`${apiUrl}/backend/formulario/deleteEmpresa.php`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        console.log(response.data);  
        if (response.data.success) {
          this.fetchEmpresas(); 
          Swal.fire('Removida!', 'Empresa removida com sucesso.', 'success');
        } else {
          Swal.fire('Erro!', 'Erro ao remover a empresa: ' + response.data.message, 'error');
          console.log(response.data.errors);  
        }
      })
      .catch(error => {
        console.error("Houve um erro ao remover a empresa:", error);
        Swal.fire('Erro!', 'Houve um erro ao remover a empresa', 'error');
      });
    }
  }
}
</script>

<style>

</style>
