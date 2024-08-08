<template>
  <div>
    <form @submit.prevent="updateEmpresa" class="max-w-full mx-auto bg-white dark:bg-gray-800 p-20 rounded-2xl shadow-lg">
      <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100 text-center">Atualizar Empresa</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card 1 -->
        <div class="card section bg-gray-200 dark:bg-gray-700 p-8 rounded-2xl">
          <!-- Dados da empresa -->
          <div class="mb-4">
            <label for="razaoSocial" class="block text-gray-800 dark:text-gray-300">Razão Social</label>
            <input type="text" v-model="empresa.razaoSocial" name="razaoSocial" id="razaoSocial" class="form-input mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" required />
          </div>
          <div class="mb-4">
            <label for="cnpj" class="block text-gray-800 dark:text-gray-300">Nº CNPJ</label>
            <input type="text" v-model="empresa.cnpj" name="cnpj" id="cnpj" class="form-input mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" required />
          </div>
          <div class="mb-4">
            <label for="inscricaoEstadual" class="block text-gray-800 dark:text-gray-300">Inscriçãoo Estadual</label>
            <input type="text" v-model="empresa.inscricaoEstadual" name="inscricaoEstadual" id="inscricaoEstadual" class="form-input mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" required />
          </div>
          <div class="mb-4">
            <label for="telefone" class="block text-gray-800 dark:text-gray-300">Telefone</label>
            <input type="text" v-model="empresa.telefone" name="telefone" id="telefone" class="form-input mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" required />
          </div>
          <div class="mb-4">
            <label for="idEstado" class="block text-gray-800 dark:text-gray-300">UF</label>
            <select v-model="empresa.idEstado" id="idEstado" name="idEstado" class="form-select mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
              <option v-for="estado in estados" :key="estado.idEstado" :value="estado.idEstado">
                {{ estado.nomeEstado }}
              </option>
            </select>
          </div>
          <!-- Checkbox  -->
          <div class="flex items-center py-2">
            <input type="hidden" name="possuiFuncionarios" :value="empresa.possuiFuncionarios ? 1 : 0">
            <input v-model="empresa.possuiFuncionarios" id="bordered-checkbox-1" type="checkbox" name="possuiFuncionarios" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
            <label for="bordered-checkbox-1" class="ml-2 text-gray-800 dark:text-gray-300">Possui Funcionários?</label>
          </div>
          <!-- Checkbox  -->
          <div class="flex items-center py-2">
            <input type="hidden" name="possuiServicos" :value="empresa.possuiServicos ? 1 : 0">
            <input v-model="empresa.possuiServicos" id="bordered-checkbox-2" type="checkbox" name="possuiServicos" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
            <label for="bordered-checkbox-2" class="ml-2 text-gray-800 dark:text-gray-300">Possui Serviços?</label>
          </div>
          <div class="mb-4 mt-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-300">Selecione o regime tributário:</h3>
            <label for="idRegimeTributario" class="block text-gray-800 dark:text-gray-300">Regime Tributário</label>
            <select v-model="empresa.idRegimeTributario" id="idRegimeTributario" name="idRegimeTributario" class="form-select mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
              <option v-for="regime in regimes" :key="regime.idRegimeTributario" :value="regime.idRegimeTributario">
                {{ regime.tipoRegime }}
              </option>
            </select>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="card section bg-gray-200 dark:bg-gray-700 p-8 rounded-2xl">
          <div class="mb-4">
            <label for="responsavelFiscal" class="block text-gray-800 dark:text-gray-300">Responsável Fiscal</label>
            <input type="text" v-model="empresa.responsavelFiscal" name="responsavelFiscal" id="responsavelFiscal" class="form-input mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" required />
          </div>
          <div class="mb-4">
            <label for="ResponsavelDp" class="block text-gray-800 dark:text-gray-300">Responsável DP</label>
            <input type="text" v-model="empresa.ResponsavelDp" name="ResponsavelDp" id="ResponsavelDp" class="form-input mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" required />
          </div>
          <div class="mb-4">
            <label for="formaDeFechamento" class="block text-gray-800 dark:text-gray-300">Forma de Fechamento</label>
            <select v-model="empresa.formaDeFechamento" id="formaDeFechamento" name="formaDeFechamento" class="form-select mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
              <option value="CartÃ£o">CartÃ£o</option>
              <option value="Nota Fiscal">Nota Fiscal</option>
              <option value="MÃ©dia">MÃ©dia</option>  
              <option value="Sem Movimento">Sem Movimento</option>
            </select>
          </div>
          <!-- Checkbox -->
          <div class="flex items-center py-2">
            <input type="hidden" name="certificadoEmitido" :value="empresa.certificadoEmitido ? 1 : 0">
            <input v-model="empresa.certificadoEmitido" id="bordered-checkbox-3" type="checkbox" name="certificadoEmitido" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
            <label for="bordered-checkbox-3" class="ml-2 text-gray-800 dark:text-gray-300">Certificado Emitido?</label>
          </div>
          <div class="mb-4 mt-6">
         <label for="processoAberturaAlteracao" class="block text-gray-800 dark:text-gray-300">Login Prefeitura</label>
         <input type="text" v-model="empresa.processoAberturaAlteracao" name="processoAberturaAlteracao" id="processoAberturaAlteracao" class="form-input mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" required />
          </div>

          <div class="mb-4">
            <label for="status" class="block text-gray-800 dark:text-gray-300">Status</label>
            <select v-model="empresa.status" id="status" name="status" class="form-select mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100">
              <option value="Ativa">Ativa</option>
              <option value="Bloqueada">Bloqueada</option>
            </select>
          </div>
          <!-- Forma de Envio -->
          <div class="mb-4">
            <label for="formaEnvio" class="block text-gray-800 dark:text-gray-300">Forma de Envio</label>
            <select v-model="empresa.formaEnvio" id="formaEnvio" name="formaEnvio" class="form-select mt-1 block w-full dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100" multiple>
              <option v-for="envio in formasEnvio" :key="envio.idEnvio" :value="envio.idEnvio">
                {{ envio.formaEnvio }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="text-center mt-8">
        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Atualizar</button>
      </div>
    </form>

    <!-- Modal de sucesso -->
    <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- ConteÃºdo do modal -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                  Empresa Atualizada
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500 dark:text-gray-300">
                    Os dados da empresa foram atualizados com sucesso.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
              OK
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
  props: ['id'],
  data() {
    return {
      empresa: {
        idEmpresa: '',
        razaoSocial: '',
        cnpj: '',
        inscricaoEstadual: '',
        telefone: '',
        idEstado: '',
        possuiFuncionarios: false,
        possuiServicos: false,
        idRegimeTributario: '',
        responsavelFiscal: '',
        ResponsavelDp: '',
        certificadoEmitido: false,
        processoAberturaAlteracao: '',
        status: '',
        formaDeFechamento: '',
        formaEnvio: []
      },
      estados: [],
      regimes: [],
      formasEnvio: [],
      showModal: false
    };
  },
  created() {
    this.fetchEmpresa();
    this.fetchEstados();
    this.fetchRegimes();
    this.fetchFormasEnvio();
  },
  methods: {
    fetchEmpresa() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/getEmpresa.php?idEmpresa=${this.id}`)
        .then(response => {
          const empresa = response.data;
          empresa.possuiFuncionarios = empresa.possuiFuncionarios == 1;
          empresa.possuiServicos = empresa.possuiServicos == 1;
          empresa.certificadoEmitido = empresa.certificadoEmitido == 1;
          empresa.formaEnvio = empresa.formaEnvio ? empresa.formaEnvio.split(',') : [];
          this.empresa = empresa;
          console.log("Dados da empresa carregados:", this.empresa);
        })
        .catch(error => {
          console.error("Houve um erro ao buscar os dados:", error);
        });
    },
    fetchEstados() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/estados.php`)
        .then(response => {
          this.estados = response.data;
          console.log("Estados carregados:", this.estados);
        })
        .catch(error => {
          console.error("Erro ao buscar estados:", error);
        });
    },
    fetchRegimes() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/regime.php`)
        .then(response => {
          this.regimes = response.data;
          console.log("Regimes carregados:", this.regimes);
        })
        .catch(error => {
          console.error("Erro ao buscar regimes:", error);
        });
    },
    fetchFormasEnvio() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/forma_de_envio.php`)
        .then(response => {
          this.formasEnvio = response.data;
          console.log("Formas de envio carregadas:", this.formasEnvio);
        })
        .catch(error => {
          console.error("Erro ao buscar formas de envio:", error);
        });
    },
    updateEmpresa() {
      const empresaData = { ...this.empresa };
      empresaData.possuiFuncionarios = this.empresa.possuiFuncionarios ? 1 : 0;
      empresaData.possuiServicos = this.empresa.possuiServicos ? 1 : 0;
      empresaData.certificadoEmitido = this.empresa.certificadoEmitido ? 1 : 0;

      console.log("Dados antes do envio:", empresaData);

      const formData = new FormData();
      for (const key in empresaData) {
        if (Array.isArray(empresaData[key])) {
          empresaData[key].forEach(value => formData.append(`${key}[]`, value));
        } else {
          formData.append(key, empresaData[key]);
        }
      }

      console.log("Dados do formData:", Array.from(formData.entries()));

      const apiUrl = import.meta.env.VITE_API_URL;
      axios.post(`${apiUrl}/backend/formulario/updateEmpresa.php`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        if (response.data.success) {
          this.showModal = true;
        } else {
          alert('Erro ao atualizar a empresa: ' + response.data.message);
        }
        console.log("Resposta do servidor:", response.data);
      })
      .catch(error => {
        console.error("Houve um erro ao atualizar a empresa:", error);
      });
    },
    closeModal() {
      this.showModal = false;
      this.$router.push({ name: 'ver_empresas' });
    }
  }
}
</script>

<style>
form {
  margin-top: 50px;
}
.section {
  background-color: #f0f0f0;
  margin-left: 10px;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.dark .section {
  background-color: #161616;
}
.card {
  width: 500px;
}
</style>
