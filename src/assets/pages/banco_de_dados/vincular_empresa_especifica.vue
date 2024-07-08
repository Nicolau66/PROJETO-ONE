<template>
  <div class="container mx-auto p-4 dark:text-white">
    <div class="overflow-x-auto mt-1">
      <div class="flex items-center justify-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Vincular Empresa Específica a Ano, Mês, Impostos e Declarações</h2>
      </div>
      <form @submit.prevent="vincularEmpresaEspecifica" class="bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-300 mb-1">Pesquisar Empresa</label>
          <input type="text" v-model="filtroEmpresa" @input="buscarEmpresa" placeholder="Digite o nome da empresa" class="w-full p-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-300 mb-1">Empresa</label>
          <select v-model="empresaSelecionada" required class="w-full p-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option value="">Selecione uma Empresa</option>
            <option v-for="empresa in empresasFiltradas" :key="empresa.idEmpresa" :value="empresa.idEmpresa">{{ empresa.razaoSocial }}</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-300 mb-1">Mês / Ano</label>
          <select v-model="mesAno" required class="w-full p-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option value="" disabled selected>Selecione Mês / Ano</option>
            <option v-for="mes in meses" :key="mes.idMes" :value="mes.idMes">{{ mes.mes }} / {{ mes.ano }}</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-300 mb-1">Impostos</label>
          <select v-model="impostosSelecionados" multiple class="w-full p-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option v-for="imposto in impostos" :key="imposto.idImposto" :value="imposto.idImposto">{{ imposto.nomeImposto }}</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-300 mb-1">Declarações</label>
          <select v-model="declaracoesSelecionadas" multiple class="w-full p-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option v-for="declaracao in declaracoes" :key="declaracao.idDeclaracao" :value="declaracao.idDeclaracao">{{ declaracao.nomeDeclaracao }}</option>
          </select>
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">Vincular</button>
      </form>
      <div v-if="message" :class="{'mt-4 p-4 rounded': true, 'bg-green-500 text-white': success, 'bg-red-500 text-white': !success}">
        {{ message }}
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
      empresaSelecionada: '',
      impostosSelecionados: [],
      declaracoesSelecionadas: [],
      message: '',
      success: true,
      meses: [],
      empresas: [],
      impostos: [],
      declaracoes: [],
      filtroEmpresa: '',
      empresasFiltradas: [] 
    }
  },
  created() {
    this.fetchMeses();
    this.fetchEmpresas();
    this.fetchImpostos();
    this.fetchDeclaracoes();
  },
  methods: {
    fetchMeses() {
      axios.get(`${apiUrl}/backend/formulario/mes.php`)
        .then(response => {
          this.meses = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os meses:", error);
        });
    },
    fetchEmpresas() {
      axios.get(`${apiUrl}/backend/formulario/getEmpresas2.php`)
        .then(response => {
          this.empresas = response.data;
          this.empresasFiltradas = this.empresas; 
        })
        .catch(error => {
          console.error("Houve um erro ao buscar as empresas:", error);
        });
    },
    fetchImpostos() {
      axios.get(`${apiUrl}/backend/formulario/impostos.php`)
        .then(response => {
          this.impostos = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os impostos:", error);
        });
    },
    fetchDeclaracoes() {
      axios.get(`${apiUrl}/backend/formulario/declaracoes.php`)
        .then(response => {
          this.declaracoes = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar as declarações:", error);
        });
    },
    buscarEmpresa() {
      this.empresasFiltradas = this.empresas.filter(empresa =>
        empresa.razaoSocial.toLowerCase().includes(this.filtroEmpresa.toLowerCase())
      );
    },
    vincularEmpresaEspecifica() {
      if (!this.mesAno || !this.empresaSelecionada) {
        this.message = 'Mês/Ano ou Empresa não fornecido';
        this.success = false;
        return;
      }

      axios.post(`${apiUrl}/backend/dp_fiscal/vincular_empresa_especifica.php`, {
        idMes: this.mesAno,
        idEmpresa: this.empresaSelecionada,
        idImpostos: this.impostosSelecionados,
        idDeclaracoes: this.declaracoesSelecionadas
      })
      .then(response => {
        this.message = response.data.message;
        this.success = true;
        Swal.fire('Sucesso', this.message, 'success');
      })
      .catch(error => {
        console.error("Houve um erro ao vincular a empresa:", error);
        this.message = 'Houve um erro ao vincular a empresa';
        this.success = false;
        Swal.fire('Erro', this.message, 'error');
      });
    }
  }
};
</script>

<style>

</style>
