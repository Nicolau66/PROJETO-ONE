<template>
  <div class="container mx-auto p-4 dark:text-white">
    <div class="grid grid-cols-3 gap-6">
      <!-- Declarações -->
      <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-2">Declarações</h3>
        <form @submit.prevent="addDeclaracao">
          <div class="mb-2">
            <label for="nomeDeclaracao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome da Declaração</label>
            <input type="text" id="nomeDeclaracao" v-model="newDeclaracao.nomeDeclaracao" class="mt-1 p-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" required>
          </div>
          <div class="mb-2">
            <label for="departamentoDeclaracao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento</label>
            <select id="departamentoDeclaracao" v-model="newDeclaracao.departamento" class="mt-1 p-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" required>
              <option value="Fiscal">Fiscal</option>
              <option value="Pessoal">Pessoal</option>
            </select>
          </div>
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">Adicionar Declaração</button>
        </form>

        <h3 class="text-lg font-bold mt-4 mb-2">Lista de Declarações</h3>
        <ul>
          <li v-for="declaracao in declaracoes" :key="declaracao.idDeclaracao" class="mb-2 flex items-center">
            <input type="text" v-model="declaracao.nomeDeclaracao" @change="updateDeclaracao(declaracao)" class="p-1 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white mr-1 flex-1 text-sm">
            <select v-model="declaracao.departamento" @change="updateDeclaracao(declaracao)" class="p-1 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white mr-1 flex-1 text-sm">
              <option value="Fiscal">Fiscal</option>
              <option value="Pessoal">Pessoal</option>
            </select>
            <button @click="deleteDeclaracao(declaracao.idDeclaracao)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Remover</button>
          </li>
        </ul>
      </div>

      <!-- Impostos -->
      <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-2">Impostos</h3>
        <form @submit.prevent="addImposto">
          <div class="mb-2">
            <label for="nomeImposto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome do Imposto</label>
            <input type="text" id="nomeImposto" v-model="newImposto.nomeImposto" class="mt-1 p-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" required>
          </div>
          <div class="mb-2">
            <label for="departamentoImposto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento</label>
            <select id="departamentoImposto" v-model="newImposto.departamento" class="mt-1 p-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" required>
              <option value="Fiscal">Fiscal</option>
              <option value="Pessoal">Pessoal</option>
            </select>
          </div>
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">Adicionar Imposto</button>
        </form>

        <h3 class="text-lg font-bold mt-4 mb-2">Lista de Impostos</h3>
        <ul>
          <li v-for="imposto in impostos" :key="imposto.idImposto" class="mb-2 flex items-center">
            <input type="text" v-model="imposto.nomeImposto" @change="updateImposto(imposto)" class="p-1 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white mr-1 flex-1 text-sm">
            <select v-model="imposto.departamento" @change="updateImposto(imposto)" class="p-1 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white mr-1 flex-1 text-sm">
              <option value="Fiscal">Fiscal</option>
              <option value="Pessoal">Pessoal</option>
            </select>
            <button @click="deleteImposto(imposto.idImposto)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Remover</button>
          </li>
        </ul>
      </div>

      <!-- Meses -->
      <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
        <h3 class="text-xl font-bold mb-2">Meses</h3>
        <form @submit.prevent="addMes">
          <div class="mb-2">
            <label for="mes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mês</label>
            <input type="number" id="mes" v-model="newMes.mes" class="mt-1 p-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" required>
          </div>
          <div class="mb-2">
            <label for="ano" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ano</label>
            <input type="number" id="ano" v-model="newMes.ano" class="mt-1 p-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" required>
          </div>
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">Adicionar Mês</button>
        </form>

        <h3 class="text-lg font-bold mt-4 mb-2">Lista de Meses</h3>
        <ul>
          <li v-for="mes in meses" :key="mes.idMes" class="mb-2 flex items-center">
            <input type="number" v-model="mes.mes" @change="updateMes(mes)" class="p-1 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white mr-1 flex-1 text-sm">
            <input type="number" v-model="mes.ano" @change="updateMes(mes)" class="p-1 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white mr-1 flex-1 text-sm">
            <button @click="deleteMes(mes.idMes)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Remover</button>
          </li>
        </ul>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
          <div>
            <div class="mt-3 text-center sm:mt-5">
              <h3 class="text-lg leading-6 font-medium text-gray-900">
                Não pode remover
              </h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  O item está vinculado a uma empresa e não pode ser excluído.
                </p>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-6">
            <button @click="showModal = false" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
              Fechar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      declaracoes: [],
      impostos: [],
      meses: [],
      newDeclaracao: {
        nomeDeclaracao: '',
        departamento: 'Fiscal'
      },
      newImposto: {
        nomeImposto: '',
        departamento: 'Fiscal'
      },
      newMes: {
        mes: '',
        ano: ''
      },
      showModal: false
    };
  },
  created() {
    this.fetchDeclaracoes();
    this.fetchImpostos();
    this.fetchMeses();
  },
  methods: {
    fetchDeclaracoes() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/declaracoes.php`)
        .then(response => {
          this.declaracoes = response.data;
        })
        .catch(error => {
          console.error('Erro ao buscar declarações:', error);
        });
    },
    fetchImpostos() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/impostos.php`)
        .then(response => {
          this.impostos = response.data;
        })
        .catch(error => {
          console.error('Erro ao buscar impostos:', error);
        });
    },
    fetchMeses() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/mes.php`)
        .then(response => {
          this.meses = response.data;
        })
        .catch(error => {
          console.error('Erro ao buscar meses:', error);
        });
    },
    addDeclaracao() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.post(`${apiUrl}/backend/cadastros/addDeclaracão.php`, this.newDeclaracao)
        .then(response => {
          this.declaracoes.push(response.data);
          this.newDeclaracao.nomeDeclaracao = '';
          this.newDeclaracao.departamento = 'Fiscal';
        })
        .catch(error => {
          console.error('Erro ao adicionar declaração:', error);
        });
    },
    addImposto() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.post(`${apiUrl}/backend/cadastros/addImposto.php`, this.newImposto)
        .then(response => {
          this.impostos.push(response.data);
          this.newImposto.nomeImposto = '';
          this.newImposto.departamento = 'Fiscal';
        })
        .catch(error => {
          console.error('Erro ao adicionar imposto:', error);
        });
    },
    addMes() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.post(`${apiUrl}/backend/cadastros/addMes.php`, this.newMes)
        .then(response => {
          this.meses.push(response.data);
          this.newMes.mes = '';
          this.newMes.ano = '';
        })
        .catch(error => {
          console.error('Erro ao adicionar mês:', error);
        });
    },
    updateDeclaracao(declaracao) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.put(`${apiUrl}/backend/cadastros/updateDeclaracao.php`, declaracao)
        .then(response => {
          console.log('Declaração atualizada com sucesso');
        })
        .catch(error => {
          console.error('Erro ao atualizar declaração:', error);
        });
    },
    updateImposto(imposto) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.put(`${apiUrl}/backend/cadastros/updateImposto.php`, imposto)
        .then(response => {
          console.log('Imposto atualizado com sucesso');
        })
        .catch(error => {
          console.error('Erro ao atualizar imposto:', error);
        });
    },
    updateMes(mes) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.put(`${apiUrl}/backend/cadastros/updateMes.php`, mes)
        .then(response => {
          console.log('Mês atualizado com sucesso');
        })
        .catch(error => {
          console.error('Erro ao atualizar mês:', error);
        });
    },
    deleteDeclaracao(idDeclaracao) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.delete(`${apiUrl}/backend/cadastros/deleteDeclaracao.php`, { data: { idDeclaracao } })
        .then(response => {
          this.declaracoes = this.declaracoes.filter(declaracao => declaracao.idDeclaracao !== idDeclaracao);
        })
        .catch(error => {
          if (error.response && error.response.status === 400) {
            this.showModal = true;
          } else {
            console.error('Erro ao remover declaração:', error);
          }
        });
    },
    deleteImposto(idImposto) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.delete(`${apiUrl}/backend/cadastros/deleteImposto.php`, { data: { idImposto } })
        .then(response => {
          this.impostos = this.impostos.filter(imposto => imposto.idImposto !== idImposto);
        })
        .catch(error => {
          if (error.response && error.response.status === 400) {
            this.showModal = true;
          } else {
            console.error('Erro ao remover imposto:', error);
          }
        });
    },
    deleteMes(idMes) {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.delete(`${apiUrl}/backend/cadastros/deleteMes.php`, { data: { idMes } })
        .then(response => {
          this.meses = this.meses.filter(mes => mes.idMes !== idMes);
        })
        .catch(error => {
          if (error.response && error.response.status === 400) {
            this.showModal = true;
          } else {
            console.error('Erro ao remover mês:', error);
          }
        });
    }
  }
}
</script>

<style>
.container {
  margin: 0 auto;
}
.section {
  background-color: #f9fafb;
}
.card {
  background-color: #ffffff;
  border-radius: 8px;
  padding: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
</style>
