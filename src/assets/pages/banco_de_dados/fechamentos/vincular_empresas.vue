<template>
  <div class="container mx-auto p-4 dark:text-white">
    <div class="overflow-x-auto mt-1">
      <div class="flex items-center justify-center mb-8">
        <h2 class="text-3xl font-bold">Vincular Empresas a Ano e Mês</h2>
      </div>
      <p class="text-center text-gray-500 mb-8">Vincule todas as empresas cadastradas a um novo ano e mês para criar um fechamento.</p>
      <form @submit.prevent="solicitarSenha">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-300 mb-1">Mês / Ano</label>
          <select v-model="mesAno" required class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option v-for="mes in meses" :key="mes.idMes" :value="mes.idMes">{{ mes.mes }} / {{ mes.ano }}</option>
          </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Vincular</button>
      </form>
      <div v-if="message" class="mt-4 p-4 bg-green-500 text-white rounded">
        {{ message }}
      </div>
      <div v-if="errorMessage" class="mt-4 p-4 bg-red-500 text-white rounded">
        {{ errorMessage }}
      </div>
      <div class="mt-4 text-center">
        <router-link to="/vincular-empresa-especifica" class="text-blue-500 hover:underline">Vincular Empresa Específica</router-link>
      </div>
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
      mesAno: '',
      message: '',
      errorMessage: '',
      meses: [],
      senha: '7894566'  
    };
  },
  created() {
    this.fetchMeses();
  },
  methods: {
    fetchMeses() {
      axios.get(`${apiUrl}/backend/formulario/mes.php`)
        .then(response => {
          this.meses = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os meses:", error);
          this.errorMessage = "Erro ao buscar os meses.";
        });
    },
    solicitarSenha() {
      Swal.fire({
        title: 'Insira a Senha',
        input: 'password',
        inputAttributes: {
          autocapitalize: 'off',
          autocorrect: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        showLoaderOnConfirm: true,
        preConfirm: (senha) => {
          if (senha !== this.senha) {
            Swal.showValidationMessage('Senha incorreta');
            return false;
          }
          return true;
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.isConfirmed) {
          this.vincularEmpresas();
        }
      });
    },
    vincularEmpresas() {
      console.log("Enviando dados:", { idMes: this.mesAno });
      axios.post(`${apiUrl}/backend/funcionalidades/vincular_empresas.php`, {
        idMes: this.mesAno
      })
      .then(response => {
        if (response.data.message) {
          this.message = response.data.message;
          Swal.fire('Sucesso', this.message, 'success');
        } else if (response.data.error) {
          this.errorMessage = response.data.error;
          Swal.fire('Erro', this.errorMessage, 'error');
        }
      })
      .catch(error => {
        console.error("Houve um erro ao vincular as empresas:", error);
        this.errorMessage = "Erro ao vincular as empresas.";
        Swal.fire('Erro', 'Houve um erro ao vincular as empresas', 'error');
      });
    }
  }
};
</script>

<style>

</style>
