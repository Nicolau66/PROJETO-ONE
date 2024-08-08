<template>
  <div class="container mx-auto p-4 dark:text-white" id="containerOne">
    <div class="overflow-x-auto mt-1">
      <div class="flex justify-center items-center mb-8">
        <img src="/src/assets/img/banco_de_dados/formulario/logoDp.png" id="logo1">
        <h2 class="text-3xl font-bold">Declarações Departamento Pessoal</h2>
      </div>
      <p class="text-center text-gray-500">Gerencie as declarações das empresas cadastradas de forma fácil e eficiente.</p>
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
            <router-link to="/dp_pessoal" class="bg-blue-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded bg-sky-600">
              Ir para Impostos
            </router-link>
          </div>
          <!-- Mês -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Mês</label>
            <select v-model="dpFilters.mes" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
              <option v-for="option in uniqueValues('mes')" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <!-- Ano -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Ano</label>
            <select v-model="dpFilters.ano" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
              <option v-for="option in uniqueValues('ano')" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <!-- Entregue -->
          <div class="flex items-center">
            <label class="block text-sm font-medium text-gray-300 mb-1 mr-2">Entregue</label>
            <input type="checkbox" v-model="dpFilters.entregue" @change="saveFilters" class="small-checkbox bg-gray-700 border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
          </div>
          <!-- Não Entregue -->
          <div class="flex items-center">
            <label class="block text-sm font-medium text-gray-300 mb-1 mr-2">Não Entregue</label>
            <input type="checkbox" v-model="dpFilters.naoEntregue" @change="saveFilters" class="small-checkbox bg-gray-700 border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
          </div>
          <!-- Favoritos -->
          <div class="flex items-center">
            <label class="block text-sm font-medium text-gray-300 mb-1 mr-2">Favoritos</label>
            <input type="checkbox" v-model="dpFilters.favoritos" @change="saveFilters" class="small-checkbox bg-gray-700 border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
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
            <th class="py-3 px-6 text-left">Declaração</th>
            <th class="py-3 px-6 text-left">Mês</th>
            <th class="py-3 px-6 text-left">Ano</th>
            <th class="py-3 px-6 text-center">Entregue</th>
            <th class="py-3 px-6 text-center bg-red-700">Dispensar</th>
            <th class="py-3 px-6 text-center">Comentário</th>
            <th class="py-3 px-6 text-center">Detalhes</th>
          </tr>
        </thead>
        <tbody class="text-gray-400 text-sm font-light">
          <tr v-for="empresa in groupedDeclaracoes" :key="empresa.idEmpresa" class="border-b border-gray-600 hover:bg-gray-700">
            <td class="py-3 px-6 text-left">
              <span @click="toggleFavorito(empresa)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'text-yellow-500': empresa.favorito, 'text-gray-500': !empresa.favorito}">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4v2m8-2v2m-7 6h6m-6 4h3m-3 4h3m2-14l-1 4m-2 0H9m4 0h3m-5-6h-1v6h1m-2-6H9v6h2M7 16h10l-1 4H8l-1-4z"/>
                </svg>
              </span>
            </td>
            <td class="py-3 px-6 text-left">{{ empresa.razaoSocial }}</td>
            <td class="py-3 px-6 text-left">{{ empresa.nomeEstado }}</td>
            <td class="py-3 px-6 text-left">{{ empresa.responsavelDp }}</td>
            <td class="py-3 px-6 text-left">
              <div v-for="declaracao in empresa.declaracoes" :key="declaracao.idDeclaracao">
                {{ declaracao.nomeDeclaracao }}
              </div>
            </td>
            <td class="py-3 px-6 text-left">
              <div v-for="declaracao in empresa.declaracoes" :key="declaracao.idDeclaracao">
                {{ declaracao.mes }}
              </div>
            </td>
            <td class="py-3 px-6 text-left">
              <div v-for="declaracao in empresa.declaracoes" :key="declaracao.idDeclaracao">
                {{ declaracao.ano }}
              </div>
            </td>
            <td class="py-3 px-6 text-center">
              <div v-for="declaracao in empresa.declaracoes" :key="declaracao.idDeclaracao">
                <input type="checkbox" v-model="declaracao.entregue" @change="confirmUpdateEntrega(declaracao, empresa.razaoSocial, declaracao.idMes)" class="small-checkbox form-checkbox text-blue-600"/>
              </div>
            </td>
            <td class="py-3 px-6 text-center">
              <div v-for="declaracao in empresa.declaracoes" :key="declaracao.idDeclaracao">
                <span @click="confirmRemoveDeclaracao(declaracao, empresa.razaoSocial)">
                  <svg xmlns="http://www.w3.org/2000/svg" class="small-icon text-red-600 cursor-pointer hover:text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </span>
              </div>
            </td>
            <td class="py-3 px-6 text-center">
              <button @click="openCommentModal(empresa)" :class="{'text-yellow-500': empresaTemComentario(empresa.idEmpresa, dpFilters.mes, dpFilters.ano), 'text-gray-500': !empresaTemComentario(empresa.idEmpresa, dpFilters.mes, dpFilters.ano)}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8h1a5 5 0 0 0 5-5V7a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v8a5 5 0 0 0 5 5z"/>
                </svg>
              </button>
            </td>
            <td class="py-3 px-6 text-center">
              <button @click="showDetails(empresa.idEmpresa)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Detalhes</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="text-white mt-4">
        <strong>Declarações Não Entregues: {{ naoEntreguesCount }}</strong>
      </div>
    </div>

    <!-- Modal existente -->
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
        <p><strong>Prefeitura:</strong> {{ empresaDetalhes.processoAberturaAlteracao }}</p>
        <p><strong>Status:</strong> {{ empresaDetalhes.status }}</p>
        <p><strong>Forma de Envio:</strong> {{ empresaDetalhes.formaEnvio }}</p>
      </div>
    </div>

    <!-- Modal para comentário -->
    <div v-if="empresaParaComentar" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-2/3 max-w-4xl modal-content">
        <div class="flex justify-between items-center">
          <h2 class="text-2xl font-bold mb-4">Adicionar Comentário</h2>
          <button @click="fecharCommentModal" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div>
          <label for="comentario" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentário</label>
          <textarea 
            id="comentario" 
            v-model="empresaParaComentar.comentario"
            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            rows="4"
            placeholder="Digite seu comentário"
          ></textarea>
          <button @click="salvarComentario" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar</button>
        </div>
      </div>
    </div>

    <!-- Speed Dial Menu -->
    <div data-dial-init class="fixed end-6 bottom-6">
      <div id="speed-dial-menu-bottom-right" :class="{'flex': isMenuOpen, 'hidden': !isMenuOpen}" class="flex-col items-center mb-4 space-y-4 dark:bg-gray-700 p-6 rounded-lg shadow-lg">
        <!-- Estado -->
        <div class="w-full mb-4">
          <label class="block text-lg font-bold text-gray-300 mb-2">Estado</label>
          <select v-model="dpFilters.nomeEstado" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option value="">Todos</option>
            <option v-for="option in uniqueValues('nomeEstado')" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>
        <!-- Responsável DP -->
        <div class="w-full mb-4">
          <label class="block text-lg font-bold text-gray-300 mb-2">Responsável DP</label>
          <select v-model="dpFilters.responsavelDp" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option value="">Todos</option>
            <option v-for="option in uniqueValues('responsavelDp')" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>
        <!-- Declaração -->
        <div class="w-full mb-4">
          <label class="block text-lg font-bold text-gray-300 mb-2">Declaração</label>
          <select multiple v-model="dpFilters.nomeDeclaracao" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
            <option value="">Todos</option>
            <option v-for="option in uniqueValues('nomeDeclaracao')" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>
        <!-- Forma de Envio -->
        <div class="w-full mb-4">
          <label class="block text-lg font-bold text-gray-300 mb-2">Forma de Envio</label>
          <select multiple v-model="dpFilters.formaEnvio" @change="saveFilters" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
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

const apiUrl = import.meta.env.VITE_API_URL;

export default {
  data() {
    return {
      declaracoes: [],
      searchQuery: '',
      dpFilters: {
        razaoSocial: '',
        nomeEstado: '',
        responsavelDp: '',
        nomeDeclaracao: [],
        mes: '',
        ano: '',
        entregue: false,
        naoEntregue: false,
        favoritos: false,
        formaEnvio: []
      },
      empresaDetalhes: null,
      isMenuOpen: false,
      favoritos: [],
      empresaParaComentar: null,
      comentarios: {}
    };
  },
  created() {
    this.loadDeclaracoesFromCache();
    this.loadFilters();
    this.loadFavoritos();
    this.fetchDeclaracoes();
  },
  methods: {
    fetchDeclaracoes() {
      axios.get(`${apiUrl}/backend/dp_pessoal/dp_declaracoes.php`)
        .then(response => {
          this.declaracoes = response.data.map(declaracao => {
            declaracao.favorito = this.favoritos.includes(declaracao.idEmpresa);
            return declaracao;
          });
          this.saveDeclaracoesToCache();
          this.loadComentarios();
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os dados:", error);
        });
    },
    uniqueValues(key) {
      const values = this.declaracoes.flatMap(declaracao => declaracao[key] ? declaracao[key].split(', ') : []);
      return [...new Set(values)];
    },
    loadComentarios() {
      this.declaracoes.forEach(declaracao => {
        axios.get(`${apiUrl}/backend/funcionalidades/get_comentario.php`, {
          params: {
            idEmpresa: declaracao.idEmpresa,
            mes: this.dpFilters.mes,
            ano: this.dpFilters.ano
          }
        })
        .then(response => {
          console.log(`Comentário carregado para empresa ${declaracao.idEmpresa} :`, response.data.comentario);
          if (response.data.comentario) {
            this.comentarios[declaracao.idEmpresa] = response.data.comentario;
          }
        })
        .catch(error => {
          console.error('Erro ao buscar comentário:', error);
        });
      });
    },
    empresaTemComentario(idEmpresa) {
      return !!this.comentarios[idEmpresa];
    },
    confirmUpdateEntrega(declaracao, razaoSocial, idMes) {
      const statusText = declaracao.entregue ? 'entregue' : 'não entregue';
      Swal.fire({
        title: 'Tem certeza?',
        text: `Você deseja marcar a declaração ${declaracao.nomeDeclaracao} da empresa ${razaoSocial} como ${statusText}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, confirmar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.updateEntrega(declaracao, idMes);
        } else {
          declaracao.entregue = !declaracao.entregue;
        }
      });
    },
    updateEntrega(declaracao, idMes) {
      console.log('Dados enviados para update_entrega_declaracao:', {
        idEmpresa: declaracao.idEmpresa,
        idDeclaracao: declaracao.idDeclaracao,
        idMes: idMes,
        entregue: declaracao.entregue
      });
      axios.post(`${apiUrl}/backend/funcionalidades/update_entrega_declaracao.php`, {
        idEmpresa: declaracao.idEmpresa,
        idDeclaracao: declaracao.idDeclaracao,
        idMes: idMes,
        entregue: declaracao.entregue
      })
      .then(response => {
        console.log('Status atualizado com sucesso:', response.data);
      })
      .catch(error => {
        console.error('Erro ao atualizar status:', error);
        declaracao.entregue = !declaracao.entregue;
      });
    },
    confirmRemoveDeclaracao(declaracao, razaoSocial) {
      Swal.fire({
        title: 'Tem certeza?',
        text: `Você deseja dispensar a declaração ${declaracao.nomeDeclaracao} da empresa ${razaoSocial} no mês ${declaracao.mes}/${declaracao.ano}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, dispensar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.removeDeclaracao(declaracao);
        }
      });
    },
    removeDeclaracao(declaracao) {
      console.log('Dados enviados para remove_declaracoes:', {
        idEmpresa: declaracao.idEmpresa,
        idDeclaracao: declaracao.idDeclaracao,
        idMes: declaracao.idMes
      });
      axios.post(`${apiUrl}/backend/funcionalidades/remove_declaracao.php`, {
        idEmpresa: declaracao.idEmpresa,
        idDeclaracao: declaracao.idDeclaracao,
        idMes: declaracao.idMes
      })
      .then(response => {
        if (response.data.success) {
          this.declaracoes = this.declaracoes.filter(i => !(i.idEmpresa === declaracao.idEmpresa && i.idDeclaracao === declaracao.idDeclaracao && i.idMes === declaracao.idMes));
          this.saveDeclaracoesToCache();
        } else {
          console.error('Erro ao remover declaração:', response.data.error);
        }
      })
      .catch(error => {
        console.error('Erro ao remover declaração:', error);
      });
    },
    filterBySearchQuery() {
      this.dpFilters.razaoSocial = this.searchQuery;
    },
    showDetails(idEmpresa) {
      axios.get(`${apiUrl}/backend/funcionalidades/empresa_detalhes.php?idEmpresa=${idEmpresa}`)
        .then(response => {
          this.empresaDetalhes = response.data;
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os detalhes da empresa:", error);
        });
    },
    openCommentModal(empresa) {
      this.empresaParaComentar = { ...empresa, comentario: '' };
      axios.get(`${apiUrl}/backend/funcionalidades/get_comentario.php`, {
        params: {
          idEmpresa: empresa.idEmpresa,
          mes: this.dpFilters.mes,
          ano: this.dpFilters.ano
        }
      })
      .then(response => {
        this.empresaParaComentar.comentario = response.data.comentario || '';
      })
      .catch(error => {
        console.error('Erro ao buscar comentário:', error);
      });
    },
    fecharCommentModal() {
      this.empresaParaComentar = null;
    },
    salvarComentario() {
      console.log('Dados enviados para salvar_comentario:', {
        idEmpresa: this.empresaParaComentar.idEmpresa,
        mes: this.dpFilters.mes,
        ano: this.dpFilters.ano,
        comentario: this.empresaParaComentar.comentario
      });
      axios.post(`${apiUrl}/backend/funcionalidades/salvar_comentario.php`, {
        idEmpresa: this.empresaParaComentar.idEmpresa,
        mes: this.dpFilters.mes,
        ano: this.dpFilters.ano,
        comentario: this.empresaParaComentar.comentario
      })
      .then(response => {
        console.log('Comentário salvo com sucesso:', response.data);
        if (response.data.success) {
          this.comentarios[this.empresaParaComentar.idEmpresa] = this.empresaParaComentar.comentario;
        }
        this.fecharCommentModal();
      })
      .catch(error => {
        console.error('Erro ao salvar comentário:', error);
      });
    },
    saveFilters() {
      const { razaoSocial, ...filtersToSave } = this.dpFilters;
      localStorage.setItem('dp_filters_declaracoes', JSON.stringify(filtersToSave));
    },
    loadFilters() {
      const savedFilters = localStorage.getItem('dp_filters_declaracoes');
      if (savedFilters) {
        this.dpFilters = { ...this.dpFilters, ...JSON.parse(savedFilters) };
      }
    },
    saveFavoritos() {
      localStorage.setItem('favoritos_declaracoes', JSON.stringify(this.favoritos));
    },
    loadFavoritos() {
      const savedFavoritos = localStorage.getItem('favoritos_declaracoes');
      if (savedFavoritos) {
        this.favoritos = JSON.parse(savedFavoritos);
      }
    },
    saveDeclaracoesToCache() {
      localStorage.setItem('declaracoes_cache', JSON.stringify(this.declaracoes));
    },
    loadDeclaracoesFromCache() {
      const cachedDeclaracoes = localStorage.getItem('declaracoes_cache');
      if (cachedDeclaracoes) {
        this.declaracoes = JSON.parse(cachedDeclaracoes);
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
    filteredDeclaracoes() {
      return this.declaracoes.filter(declaracao => {
        const isEntregueMatch = this.dpFilters.entregue ? declaracao.entregue : true;
        const isNaoEntregueMatch = this.dpFilters.naoEntregue ? !declaracao.entregue : true;
        const isNomeDeclaracaoMatch = this.dpFilters.nomeDeclaracao.length === 0 || this.dpFilters.nomeDeclaracao.includes(declaracao.nomeDeclaracao) || this.dpFilters.nomeDeclaracao.includes("");
        const isFormaEnvioMatch = this.dpFilters.formaEnvio.length === 0 || (declaracao.formaEnvio && this.dpFilters.formaEnvio.some(envio => declaracao.formaEnvio.includes(envio)));
        const isFavoritoMatch = this.dpFilters.favoritos ? declaracao.favorito : true;
        return (!this.dpFilters.razaoSocial || declaracao.razaoSocial.toLowerCase().includes(this.dpFilters.razaoSocial.toLowerCase())) &&
               (!this.dpFilters.nomeEstado || declaracao.nomeEstado === this.dpFilters.nomeEstado) &&
               (!this.dpFilters.responsavelDp || declaracao.responsavelDp === this.dpFilters.responsavelDp) &&
               isNomeDeclaracaoMatch &&
               (!this.dpFilters.mes || declaracao.mes.toString() === this.dpFilters.mes) &&
               (!this.dpFilters.ano || declaracao.ano.toString() === this.dpFilters.ano) &&
               isEntregueMatch &&
               isNaoEntregueMatch &&
               isFavoritoMatch &&
               isFormaEnvioMatch;
      });
    },
    groupedDeclaracoes() {
      const grouped = this.filteredDeclaracoes.reduce((acc, declaracao) => {
        const empresa = acc.find(item => item.idEmpresa === declaracao.idEmpresa);
        if (empresa) {
          empresa.declaracoes.push(declaracao);
        } else {
          acc.push({
            idEmpresa: declaracao.idEmpresa,
            razaoSocial: declaracao.razaoSocial,
            nomeEstado: declaracao.nomeEstado,
            responsavelDp: declaracao.responsavelDp,
            favorito: declaracao.favorito,
            declaracoes: [declaracao],
            comentario: this.comentarios[declaracao.idEmpresa] || null
          });
        }
        return acc;
      }, []);
      return grouped;
    },
    naoEntreguesCount() {
      return this.declaracoes.filter(declaracao => !declaracao.entregue).length;
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

.small-checkbox {
  width: 16px;
  height: 16px;
}

.small-icon {
  width: 20px;
  height: 20px;
}
</style>
