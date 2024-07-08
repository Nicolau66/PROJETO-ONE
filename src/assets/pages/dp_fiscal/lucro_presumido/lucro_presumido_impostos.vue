<template>
  <div class="container mx-auto p-4 dark:text-white" id="containerOne">
    <div class="overflow-x-auto mt-1">
      <div class="flex justify-center items-center mb-8">
        <img src="/src/assets/img/banco_de_dados/formulario/LogoLucroPresumido.png" id="logo1">
        <h2 class="text-3xl font-bold">Impostos do Lucro Presumido</h2>
        
      </div>
      <p class="text-center text-gray-500">Gerencie os impostos das empresas cadastradas no Lucro Presumido de forma fácil e eficiente.</p>
      <br>
      <br>
        <div class="flex justify-between items-center mb-4">
          <form class="max-w-md mx-auto mb-4" id="pesquisa" @submit.prevent>
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
              </div>
              <input 
                type="search" 
                id="default-search" 
                v-model="searchQuery" 
                @input="filterBySearchQuery"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Pesquisar Empresa..." 
                required 
              />
            </div>
          </form>
          <div class="flex space-x-4">
            <div class="buttonAlternar">
              <router-link to="/lucro_presumido" class="bg-blue-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded bg-yellow-600">
                Voltar para Declarações
              </router-link>
            </div>
            <!-- Mês -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Mês</label>
              <select v-model="filters.mes" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                
                <option v-for="option in uniqueValues('mes')" :key="option" :value="option">{{ option }}</option>
              </select>
            </div>
            <!-- Ano -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1">Ano</label>
              <select v-model="filters.ano" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                
                <option v-for="option in uniqueValues('ano')" :key="option" :value="option">{{ option }}</option>
              </select>
            </div>
            <!-- Entregue -->
            <div class="flex items-center">
              <label class="block text-sm font-medium text-gray-300 mb-1 mr-2">Entregue</label>
              <input type="checkbox" v-model="filters.entregue" @change="saveFilters" class="bg-gray-700 border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <!-- Não Entregue -->
            <div class="flex items-center">
              <label class="block text-sm font-medium text-gray-300 mb-1 mr-2">Não Entregue</label>
              <input type="checkbox" v-model="filters.naoEntregue" @change="saveFilters" class="bg-gray-700 border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <!-- Favoritos -->
            <div class="flex items-center">
              <label class="block text-sm font-medium text-gray-300 mb-1 mr-2">Favoritos</label>
              <input type="checkbox" v-model="filters.favoritos" @change="saveFilters" class="bg-gray-700 border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
          </div>
        </div>
        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg shadow-lg">
          <thead class="bg-gray-700 text-gray-300 uppercase text-sm leading-normal">
            <tr>
              <th class="py-3 px-6 text-left">Favorito</th>
              <th class="py-3 px-6 text-left">Empresa</th>
              <th class="py-3 px-6 text-left">Estado</th>
              <th class="py-3 px-6 text-left">Responsável</th>
              <th class="py-3 px-6 text-left">Fechamento</th>
              <th class="py-3 px-6 text-left">Imposto</th>
              <th class="py-3 px-6 text-left">Mês</th>
              <th class="py-3 px-6 text-left">Ano</th>
              <th class="py-3 px-6 text-center">Entregue</th>
              <th class="py-3 px-6 text-center bg-red-700">Dispensar</th>
              <th class="py-3 px-6 text-center">Detalhes</th>
            </tr>
          </thead>
          <tbody class="text-gray-400 text-sm font-light">
            <tr v-for="empresa in groupedImpostos" :key="empresa.idEmpresa" class="border-b border-gray-600 hover:bg-gray-700">
              <td class="py-3 px-6 text-left">
                <span @click="toggleFavorito(empresa)">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'text-yellow-500': empresa.favorito, 'text-gray-500': !empresa.favorito}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v2m8-2v2m-7 6h6m-6 4h3m-3 4h3m2-14l-1 4m-2 0H9m4 0h3m-5-6h-1v6h1m-2-6H9v6h2M7 16h10l-1 4H8l-1-4zm0 0h10l-1 4H8l-1-4z"/>
                  </svg>
                </span>
              </td>
              <td class="py-3 px-6 text-left">{{ empresa.razaoSocial }}</td>
              <td class="py-3 px-6 text-left">{{ empresa.nomeEstado }}</td>
              <td class="py-3 px-6 text-left">{{ empresa.responsavelFiscal }}</td>
              <td class="py-3 px-6 text-left">{{ empresa.formaDeFechamento }}</td>
              <td class="py-3 px-6 text-left">
                <div v-for="imposto in empresa.impostos" :key="imposto.idImposto">
                  {{ imposto.nomeImposto }}
                </div>
              </td>
              <td class="py-3 px-6 text-left">
                <div v-for="imposto in empresa.impostos" :key="imposto.idImposto">
                  {{ imposto.mes }}
                </div>
              </td>
              <td class="py-3 px-6 text-left">
                <div v-for="imposto in empresa.impostos" :key="imposto.idImposto">
                  {{ imposto.ano }}
                </div>
              </td>
              <td class="py-3 px-6 text-center">
                <div v-for="imposto in empresa.impostos" :key="imposto.idImposto">
                  <input type="checkbox" v-model="imposto.entregue" @change="confirmUpdateEntrega(imposto, empresa.razaoSocial)" class="form-checkbox h-4 w-4 text-blue-600"/>
                </div>
              </td>
              <td class="py-3 px-6 text-center">
                <div v-for="imposto in empresa.impostos" :key="imposto.idImposto">
                  <span @click="confirmRemoveImposto(imposto, empresa.razaoSocial)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 cursor-pointer hover:text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </span>
                </div>
              </td>
              <td class="py-3 px-6 text-center">
                <button @click="showDetails(empresa.idEmpresa)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Detalhes</button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-white mt-4">
          <strong>Impostos Não Entregues: {{ naoEntreguesCount }}</strong>
        </div>
      </div>
  
      <!-- Modal -->
      <div v-if="empresaDetalhes" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-2/3 max-w-4xl modal-content">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold mb-4">{{ empresaDetalhes.razaoSocial }}</h2>
            <button @click="empresaDetalhes = null" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <p><strong>CNPJ:</strong> {{ empresaDetalhes.cnpj }}</p>
          <p><strong>Inscrição Estadual:</strong> {{ empresaDetalhes.inscricaoEstadual }}</p>
          <p><strong>Telefone:</strong> {{ empresaDetalhes.telefone }}</p>
          <p><strong>Estado:</strong> {{ empresaDetalhes.nomeEstado }}</p>
          <p><strong>Regime Tributário:</strong> {{ empresaDetalhes.nomeRegimeTributario }}</p>
          <p><strong>Possui Funcionários:</strong> {{ empresaDetalhes.possuiFuncionarios == 1 ? 'Sim' : 'Não' }}</p>
          <p><strong>Responsável Fiscal:</strong> {{ empresaDetalhes.responsavelFiscal }}</p>
          <p><strong>Responsável DP:</strong> {{ empresaDetalhes.ResponsavelDp }}</p>
          <p><strong>Certificado Emitido:</strong> {{ empresaDetalhes.certificadoEmitido == 1 ? 'Sim' : 'Não' }}</p>
          <p><strong>Processo de Abertura/Alteração:</strong> {{ empresaDetalhes.processoAberturaAlteracao }}</p>
          <p><strong>Status:</strong> {{ empresaDetalhes.status }}</p>
          <p><strong>Forma de Envio:</strong> {{ empresaDetalhes.formaEnvio }}</p>
          <p><strong>Forma de Fechamento:</strong> {{ empresaDetalhes.formaDeFechamento }}</p>
        </div>
      </div>
  
      <!-- Speed Dial Menu -->
      <div data-dial-init class="fixed end-6 bottom-6">
        <div id="speed-dial-menu-bottom-right" :class="{'flex': isMenuOpen, 'hidden': !isMenuOpen}" class="flex-col items-center mb-4 space-y-4 dark:bg-gray-700 p-6 rounded-lg shadow-lg">
          <!-- Estado -->
          <div class="w-full mb-4">
            <label class="block text-lg font-bold text-gray-300 mb-2">Estado</label>
            <select v-model="filters.nomeEstado" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
              <option value="">Todos</option>
              <option v-for="option in uniqueValues('nomeEstado')" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <!-- Responsável Fiscal -->
          <div class="w-full mb-4">
            <label class="block text-lg font-bold text-gray-300 mb-2">Responsável Fiscal</label>
            <select v-model="filters.responsavelFiscal" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
              <option value="">Todos</option>
              <option v-for="option in uniqueValues('responsavelFiscal')" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <!-- Forma de Fechamento -->
          <div class="w-full mb-4">
            <label class="block text-lg font-bold text-gray-300 mb-2">Forma de Fechamento</label>
            <select v-model="filters.formaDeFechamento" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
              <option value="">Todas</option>
              <option v-for="option in uniqueValues('formaDeFechamento')" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <!-- Imposto -->
          <div class="w-full mb-4">
            <label class="block text-lg font-bold text-gray-300 mb-2">Imposto</label>
            <select multiple v-model="filters.nomeImposto" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
              <option value="">Todos</option>
              <option v-for="option in uniqueValues('nomeImposto')" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <!-- Forma de Envio -->
          <div class="w-full mb-4">
            <label class="block text-lg font-bold text-gray-300 mb-2">Forma de Envio</label>
            <select multiple v-model="filters.formaEnvio" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
              <option value="">Todos</option>
              <option v-for="option in uniqueValues('formaEnvio')" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
        </div>
        <button type="button" @click="toggleMenu" aria-controls="speed-dial-menu-bottom-right" aria-expanded="false" class="flex items-center justify-center text-white bg-blue-700 rounded-full w-14 h-14 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
          <svg class="w-5 h-5 transition-transform group-hover:rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
          </svg>
          <span class="sr-only">Open actions menu</span>
        </button>
      </div>
    </div>
  </template>
  
  <script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      impostos: [],
      searchQuery: '',
      filters: {
        razaoSocial: '',
        nomeEstado: '',
        responsavelFiscal: '',
        formaDeFechamento: '',
        nomeImposto: [],
        mes: '',
        ano: '',
        entregue: false,
        naoEntregue: false,
        favoritos: false
      },
      empresaDetalhes: null,
      isMenuOpen: false,
      favoritos: []
    };
  },
  created() {
    this.fetchImpostos();
    this.loadFilters();
    this.loadFavoritos();
  },
  methods: {
    fetchImpostos() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/dp_fiscal/lucro_presumido/lp_impostos.php`)
        .then(response => {
          console.log('Dados recebidos:', response.data);
          this.impostos = response.data.map(imposto => {
            imposto.favorito = this.favoritos.includes(imposto.idEmpresa);
            return imposto;
          });
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os dados:", error);
        });
    },
    uniqueValues(key) {
      const values = this.impostos.map(imposto => imposto[key]);
      return [...new Set(values)];
    },
    confirmUpdateEntrega(imposto, razaoSocial) {
      const statusText = imposto.entregue ? 'entregue' : 'não entregue';
      Swal.fire({
        title: 'Tem certeza?',
        text: `Você deseja marcar o imposto ${imposto.nomeImposto} da empresa ${razaoSocial} como ${statusText}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, confirmar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.updateEntrega(imposto);
        } else {
        
          imposto.entregue = !imposto.entregue;
        }
      });
    },
    updateEntrega(imposto) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.post(`${apiUrl}/backend/dp_fiscal/lucro_presumido/update_entrega_imposto.php`, {
        idEmpresa: imposto.idEmpresa,
        idImposto: imposto.idImposto,
        entregue: imposto.entregue
      })
      .then(response => {
        console.log('Status atualizado com sucesso:', response.data);
      })
      .catch(error => {
        console.error('Erro ao atualizar status:', error);
        imposto.entregue = !imposto.entregue; 
      });
    },
    confirmRemoveImposto(imposto, razaoSocial) {
      Swal.fire({
        title: 'Tem certeza?',
        text: `Você deseja dispensar o imposto ${imposto.nomeImposto} da empresa ${razaoSocial} no mês ${imposto.mes}/${imposto.ano}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, dispensar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.removeImposto(imposto);
        }
      });
    },
    removeImposto(imposto) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.post(`${apiUrl}/backend/dp_fiscal/lucro_presumido/remove_imposto.php`, {
        idEmpresa: imposto.idEmpresa,
        idImposto: imposto.idImposto,
        idMes: imposto.mes
      })
      .then(response => {
        console.log('Imposto removido com sucesso:', response.data);
       
        this.impostos = this.impostos.filter(i => !(i.idEmpresa === imposto.idEmpresa && i.idImposto === i.idImposto && i.mes === imposto.mes));
      })
      .catch(error => {
        console.error('Erro ao remover imposto:', error);
      });
    },
    filterBySearchQuery() {
      this.filters.razaoSocial = this.searchQuery;
    },
    showDetails(idEmpresa) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/dp_fiscal/empresa_detalhes.php?idEmpresa=${idEmpresa}`)
        .then(response => {
          this.empresaDetalhes = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os detalhes da empresa:", error);
        });
    },
    saveFilters() {
      const { razaoSocial, ...filtersToSave } = this.filters;
      localStorage.setItem('filters_lp_impostos', JSON.stringify(filtersToSave));
    },
    loadFilters() {
      const savedFilters = localStorage.getItem('filters_lp_impostos');
      if (savedFilters) {
        this.filters = { ...this.filters, ...JSON.parse(savedFilters) };
      }
    },
    saveFavoritos() {
      localStorage.setItem('favoritos_lp_impostos', JSON.stringify(this.favoritos));
    },
    loadFavoritos() {
      const savedFavoritos = localStorage.getItem('favoritos_lp_impostos');
      if (savedFavoritos) {
        this.favoritos = JSON.parse(savedFavoritos);
      }
    },
    toggleFavorito(empresa) {
      if (empresa.favorito) {
        this.favoritos = this.favoritos.filter(fav => fav !== empresa.idEmpresa);
      } else {
        this.favoritos.push(empresa.idEmpresa);
      }
      empresa.favorito = !empresa.favorito;
      this.saveFavoritos();
      this.$forceUpdate(); 
    },
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    }
  },
  computed: {
    filteredImpostos() {
      return this.impostos.filter(imposto => {
        const isEntregueMatch = this.filters.entregue ? imposto.entregue : true;
        const isNaoEntregueMatch = this.filters.naoEntregue ? !imposto.entregue : true;
        const isNomeImpostoMatch = this.filters.nomeImposto.length === 0 || this.filters.nomeImposto.includes(imposto.nomeImposto) || this.filters.nomeImposto.includes("");
        const isFavoritoMatch = this.filters.favoritos ? imposto.favorito : true;
        return (!this.filters.razaoSocial || imposto.razaoSocial.toLowerCase().includes(this.filters.razaoSocial.toLowerCase())) &&
               (!this.filters.nomeEstado || imposto.nomeEstado === this.filters.nomeEstado) &&
               (!this.filters.responsavelFiscal || imposto.responsavelFiscal === this.filters.responsavelFiscal) &&
               (!this.filters.formaDeFechamento || imposto.formaDeFechamento === this.filters.formaDeFechamento) &&
               isNomeImpostoMatch &&
               (!this.filters.mes || imposto.mes.toString() === this.filters.mes) &&
               (!this.filters.ano || imposto.ano.toString() === this.filters.ano) &&
               isEntregueMatch &&
               isNaoEntregueMatch &&
               isFavoritoMatch;
      });
    },
    groupedImpostos() {
      const grouped = this.filteredImpostos.reduce((acc, imposto) => {
        const empresa = acc.find(item => item.idEmpresa === imposto.idEmpresa);
        if (empresa) {
          empresa.impostos.push(imposto);
        } else {
          acc.push({
            idEmpresa: imposto.idEmpresa,
            razaoSocial: imposto.razaoSocial,
            nomeEstado: imposto.nomeEstado,
            responsavelFiscal: imposto.responsavelFiscal,
            formaDeFechamento: imposto.formaDeFechamento,
            favorito: imposto.favorito,
            impostos: [imposto]
          });
        }
        return acc;
      }, []);
      return grouped;
    },
    naoEntreguesCount() {
      return this.impostos.filter(imposto => !imposto.entregue).length;
    }
  }
}

  </script>
  
  <style>
  #speed-dial-menu-bottom-right {
    background-color: #1f1f1f; 
  }
  
  #containerOne {
    margin: 0;
  }
  
  form {
    margin-top: 0px;
    margin-right: 10px;
  }
  
  .section {
    width: 500px;
    background-color: #161616; 
    margin-left: 10px;
  }
  
  .card {
    width: 500px;
    background-color: #1a1a1a; 
  }
  
  .fixed.inset-0 {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .modal-content {
    max-height: 90vh; 
    overflow-y: auto;
  }
  
  .buttonAlternar {
    margin-top: 35px;
  }
  
  .text-yellow-500 {
    color: #FFD700;
  }
  
  .text-gray-500 {
    color: #6B7280;
  }
  </style>
  