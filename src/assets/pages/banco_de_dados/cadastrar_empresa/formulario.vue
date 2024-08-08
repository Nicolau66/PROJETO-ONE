<template>
  <div class="container mx-auto p-10 dark:text-white" id="containerOne">
    <form class="max-w-full mx-auto" @submit.prevent="submitForm">
      <div class="flex flex-row justify-center space-x-4">
        <!-- Card 1 -->
        <div class="card section dark:bg-gray-800 p-8 rounded-2xl" id="section1">
          <CustomInput type="text" name="razaoSocial" id="razaoSocial" label="Razão Social" required />
          <CustomInput type="text" name="cnpj" id="cnpj" label="Nº CNPJ" placeholder=" " v-mask="'##.###.###/####-##'" required />
          <CustomInput type="text" name="inscricaoEstadual" id="inscricaoEstadual" label="Inscrição Estadual" placeholder=" " required />
          <CustomInput type="tel" name="telefone" id="telefone" label="Telefone" placeholder=" " required />
          <CustomSelect id="underline_select_uf" name="idEstado" label="UF" :options="estados.map(estado => ({ value: estado.idEstado, text: estado.nomeEstado }))" required />
          <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 mt-2">
            <input id="bordered-checkbox-1" type="checkbox" name="possuiFuncionarios" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="bordered-checkbox-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Possui Funcionários?</label>
          </div>
          <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 mt-2">
            <input id="bordered-checkbox-2" type="checkbox" name="possuiServicos" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="bordered-checkbox-2" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Possui Serviços?</label>
          </div>
          <br>
          <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Selecione o regime tributário:</h3>
          <CustomSelect id="underline_select_uf" name="idRegimeTributario" label="Regime Tributario" :options="regime.map(regime => ({ value: regime.idRegimeTributario, text: regime.tipoRegime }))" required />
        </div>

        <!-- Card 2 -->
        <div class="card section dark:bg-gray-800 p-8 rounded-2xl" id="section2">
          <CustomInput type="text" name="responsavelFiscal" id="responsavelFiscal" label="Responsável Fiscal" required />
          <CustomInput type="text" name="responsavelDp" id="responsavelDp" label="Responsável DP" required />
          <CustomSelect id="formaDeFechamento" name="formaDeFechamento" label="Forma de fechamento" :options="[
            { value: '', text: 'Forma de Fechamento' },
            { value: 'Cartão', text: 'Cartão' },
            { value: 'Nota Fiscal', text: 'Nota Fiscal' },
            { value: 'Média', text: 'Média' },
            { value: 'Sem Movimento', text: 'Sem Movimento' }
          ]" required />
          <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 mt-2">
            <input id="bordered-checkbox-3" type="checkbox" value="1" name="certificadoEmitido" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="bordered-checkbox-3" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Certificado Emitido?</label>
          </div>
          <br>
          <CustomInput type="text" name="processoAberturaAlteracao" id="process_type" label="Login Prefeitura" required />

          <CustomSelect id="status" name="status" label="Status" :options="[
            { value: 'Ativa', text: 'Ativa' },
            { value: 'Bloqueada', text: 'Bloqueada' }
          ]" required />
        </div>

        <!-- Card 3 -->
        <div class="card section dark:bg-gray-800 p-8 rounded-2xl" id="section3">
          <label for="declaracoes_multiple" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione as declarações</label>
          <select multiple id="declaracoes_multiple" name="declaracoes[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            <option v-for="declaracao in declaracoes" :key="declaracao.idDeclaracao" :value="declaracao.idDeclaracao">
              {{ declaracao.nomeDeclaracao }}
            </option>
          </select>
          <br>
          <label for="impostos_multiple" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione os impostos</label>
          <select multiple id="impostos_multiple" name="impostos[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            <option v-for="imposto in impostos" :key="imposto.idImposto" :value="imposto.idImposto">
              {{ imposto.nomeImposto }}
            </option>
          </select>
          <br>
          <label for="forma_envio_multiple" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecione a forma de envio</label>
          <select multiple id="forma_envio_multiple" name="formaEnvio[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            <option v-for="envio in envio" :key="envio.idEnvio" :value="envio.idEnvio">
              {{ envio.formaEnvio }}
            </option>
            <br>
          </select>
          <br>
          <CustomSelect id="underline_select_mes" name="mes" label="Mes e Ano" :options="mes.map(m => ({ value: m.idMes, text: `${m.mes} ${m.ano}` }))" required />
        </div>
      </div>
      <div class="text-center mt-4">
        <button type="submit" class="text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">Cadastrar</button>
      </div>
    </form>
  </div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import CustomInput from '../../../../components/formulario/inputs.vue';
import CustomSelect from '../../../../components/formulario/selects.vue';
import { mask } from 'vue-the-mask';

export default {
  components: {
    CustomInput,
    CustomSelect,
  },
  directives: { mask },
  data() {
    return {
      estados: [],
      declaracoes: [],
      impostos: [],
      mes: [],
      envio: [],
      regime: []
    };
  },
  created() {
    this.fetchEstados();
    this.fetchDeclaracoes();
    this.fetchImpostos();
    this.fetchMes();
    this.fetchEnvio();
    this.fetchRegime();
  },
  methods: {
    fetchEstados() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/estados.php`)
        .then(response => {
          this.estados = response.data;
        });
    },
    fetchDeclaracoes() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/declaracoes.php`)
        .then(response => {
          this.declaracoes = response.data;
        });
    },
    fetchImpostos() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/impostos.php`)
        .then(response => {
          this.impostos = response.data;
        });
    },
    fetchMes() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/mes.php`)
        .then(response => {
          this.mes = response.data;
        });
    },
    fetchEnvio() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/forma_de_envio.php`)
        .then(response => {
          this.envio = response.data;
        });
    },
    fetchRegime() {
      const apiUrl = import.meta.env.VITE_API_URL;
      axios.get(`${apiUrl}/backend/formulario/regime.php`)
        .then(response => {
          this.regime = response.data;
        });
    },
    submitForm() {
      const apiUrl = import.meta.env.VITE_API_URL;
      const form = document.querySelector('form');
      const formData = new FormData(form);

      axios.post(`${apiUrl}/backend/formulario/inputForm.php`, formData)
        .then(response => {
          console.log('Resposta do servidor:', response.data);
          Swal.fire({
            title: 'Empresa cadastrada!',
            text: 'A empresa foi cadastrada com sucesso.',
            icon: 'success',
            confirmButtonText: 'Ok'
          });
        })
        .catch(error => {
          console.error('Erro na requisiÃ§Ã£o:', error);
          Swal.fire({
            title: 'Erro!',
            text: 'Houve um problema ao cadastrar a empresa.',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        });
    }
  }
}


</script>
<style>
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

.button-remove {
  margin-left: 8px;
  color: red;
  cursor: pointer;
}

.button-add {
  margin-top: 8px;
  color: blue;
  cursor: pointer;
}
</style>
