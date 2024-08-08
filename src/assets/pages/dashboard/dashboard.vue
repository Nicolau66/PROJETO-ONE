<template>
    <div>
      <!-- Modal de Seleção de Mês e Ano -->
      <div v-if="showModal" class="modal-overlay">
        <div class="modal-container">
          <div class="modal-header">
            <i class="fas fa-calendar modal-icon"></i>
            <h2 class="modal-title">Selecione o Mês e o Ano</h2>
          </div>
          <div class="modal-filters">
            <div>
              <label for="modalYearFilter" class="filter-label">Ano:</label>
              <select id="modalYearFilter" v-model="modalSelectedYear" class="filter-select animated">
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
              </select>
            </div>
            <div>
              <label for="modalMonthFilter" class="filter-label">Mês:</label>
              <select id="modalMonthFilter" v-model="modalSelectedMonth" class="filter-select animated">
                <option v-for="(month, index) in months" :key="index" :value="index + 1">{{ month }}</option>
              </select>
            </div>
          </div>
          <div class="modal-actions">
            <button @click="applyModalFilters" class="modal-button">Aplicar</button>
          </div>
          <div v-if="modalErrorMessage" class="text-center text-red-500 mt-4">
            {{ modalErrorMessage }}
          </div>
        </div>
      </div>
  
      <!-- Seletor de ano -->
      <div class="filters flex justify-center space-x-4 mb-6">
        <div>
          <label for="yearFilter" class="filter-label">Ano:</label>
          <select id="yearFilter" v-model="selectedYear" @change="validateFilters" class="filter-select animated">
            <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
          </select>
        </div>
        <div>
          <label for="monthFilter" class="filter-label">Mês:</label>
          <select id="monthFilter" v-model="selectedMonth" @change="validateFilters" class="filter-select animated">
            <option v-for="(month, index) in months" :key="index" :value="index + 1">{{ month }}</option>
          </select>
        </div>
      </div>
  
      <!-- Seletor de impostos e declarações -->
      <div class="filters flex justify-center space-x-4 mb-6">
        <div>
          <select id="impostosFilter" v-model="selectedImpostos" multiple @change="validateFilters" class="filter-select animated">
            <option v-for="imposto in allImpostos" :key="imposto" :value="imposto">{{ imposto }}</option>
          </select>
        </div>
        <div>
          <select id="declarationsFilter" v-model="selectedDeclarations" multiple @change="validateFilters" class="filter-select animated">
            <option v-for="declaration in allDeclarations" :key="declaration" :value="declaration">{{ declaration }}</option>
          </select>
        </div>
      </div>
  
      <!-- Gráficos -->
      <div v-if="filtersValid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="chart-container animated">
          <h3 class="chart-title">Impostos</h3>
          <canvas v-if="filtersValid" id="impostosChart" class="chart-canvas"></canvas>
        </div>
        <div class="chart-container animated">
          <h3 class="chart-title">Declarações</h3>
          <canvas v-if="filtersValid" id="declaracoesChart" class="chart-canvas"></canvas>
        </div>
      </div>
  
      <!-- Mensagem de erro -->
      <div v-else class="text-center text-red-500 mt-6">
        {{ filtersErrorMessage }}
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { Chart, registerables } from 'chart.js';
  Chart.register(...registerables);
  
  export default {
    data() {
      return {
        impostosData: [],
        declaracoesData: [],
        selectedYear: '',
        selectedMonth: '',
        selectedDeclarations: [],
        selectedImpostos: [],
        modalSelectedYear: '',
        modalSelectedMonth: '',
        years: [],
        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        allDeclarations: [],
        allImpostos: [],
        filtersValid: false,
        filtersErrorMessage: '',
        modalErrorMessage: '',
        showModal: true
      };
    },
    watch: {
      selectedYear() {
        this.validateFilters();
      },
      selectedMonth() {
        this.validateFilters();
      },
      selectedDeclarations() {
        this.validateFilters();
      },
      selectedImpostos() {
        this.validateFilters();
      },
      filtersValid(newVal) {
        if (newVal) {
          this.renderCharts();
        }
      }
    },
    mounted() {
      this.fetchData();
      window.addEventListener('resize', this.renderCharts);
    },
    beforeDestroy() {
      window.removeEventListener('resize', this.renderCharts);
    },
    methods: {
      fetchData() {
        axios.get(`${import.meta.env.VITE_API_URL}/backend/dashboard/dashboard_data.php`)
          .then(response => {
            console.log("Dados recebidos da API:", response.data);
            this.processData(response.data);
            this.$nextTick().then(() => {
              this.validateFilters(); // Atualizar validação após o carregamento dos dados
            });
          })
          .catch(error => {
            console.error("Erro ao buscar os dados do dashboard:", error);
          });
      },
      processData(data) {
        if (data && data.impostos && Array.isArray(data.impostos)) {
          console.log("Dados de impostos processados:", data.impostos);
          this.impostosData = data.impostos;
          this.allImpostos = Array.from(new Set(data.impostos.map(item => item.nome)));
        } else {
          console.error("Dados de impostos não estão no formato esperado.", data.impostos);
        }
  
        if (data && data.declaracoes && Array.isArray(data.declaracoes)) {
          console.log("Dados de declarações processados:", data.declaracoes);
          this.declaracoesData = data.declaracoes;
          this.allDeclarations = Array.from(new Set(data.declaracoes.map(item => item.nome)));
        } else {
          console.error("Dados de declarações não estão no formato esperado.", data.declaracoes);
        }
  
        // Gerar lista de anos disponíveis
        this.years = Array.from(new Set([...this.impostosData, ...this.declaracoesData].map(item => item.ano))).sort();
      },
      validateFilters() {
        this.filtersValid = this.selectedYear && this.selectedMonth;
        this.filtersErrorMessage = this.filtersValid ? '' : 'Por favor, selecione um mês e um ano para visualizar os gráficos.';
        if (this.filtersValid) {
          this.$nextTick(() => this.renderCharts()); // Certifique-se de que o DOM está atualizado
        }
      },
      applyModalFilters() {
        if (!this.modalSelectedYear || !this.modalSelectedMonth) {
          this.modalErrorMessage = 'Por favor, selecione tanto o mês quanto o ano.';
          return;
        }
        this.modalErrorMessage = '';
        this.selectedYear = this.modalSelectedYear;
        this.selectedMonth = this.modalSelectedMonth;
        this.showModal = false;
        document.body.style.overflow = ''; // Restaurar o scroll da página
        this.validateFilters();
      },
      renderCharts() {
        if (!this.filtersValid) return;
  
        this.$nextTick(() => {
          const ctxImpostos = document.getElementById('impostosChart');
          if (!ctxImpostos) {
            console.error('Canvas para impostosChart não encontrado');
            return;
          }
          const ctxImpostos2D = ctxImpostos.getContext('2d');
          if (!ctxImpostos2D) {
            console.error('Contexto 2D para impostosChart não encontrado');
            return;
          }
  
          const ctxDeclaracoes = document.getElementById('declaracoesChart');
          if (!ctxDeclaracoes) {
            console.error('Canvas para declaracoesChart não encontrado');
            return;
          }
          const ctxDeclaracoes2D = ctxDeclaracoes.getContext('2d');
          if (!ctxDeclaracoes2D) {
            console.error('Contexto 2D para declaracoesChart não encontrado');
            return;
          }
  
          const filteredImpostosData = this.impostosData.filter(item =>
            (this.selectedYear ? item.ano === this.selectedYear : true) &&
            (this.selectedMonth ? item.mes == this.selectedMonth : true) &&
            (this.selectedImpostos.length ? this.selectedImpostos.includes(item.nome) : true)
          );
  
          const filteredDeclaracoesData = this.declaracoesData.filter(item =>
            (this.selectedYear ? item.ano === this.selectedYear : true) &&
            (this.selectedMonth ? item.mes == this.selectedMonth : true) &&
            (this.selectedDeclarations.length ? this.selectedDeclarations.includes(item.nome) : true)
          );
  
          const impostosLabels = filteredImpostosData.map(item => item.nome);
          const impostosEntregues = filteredImpostosData.map(item => item.entregues);
          const impostosNaoEntregues = filteredImpostosData.map(item => item.naoEntregues);
  
          const declaracoesLabels = filteredDeclaracoesData.map(item => item.nome);
          const declaracoesEntregues = filteredDeclaracoesData.map(item => item.entregues);
          const declaracoesNaoEntregues = filteredDeclaracoesData.map(item => item.naoEntregues);
  
          if (this.impostosChart) this.impostosChart.destroy();
          if (this.declaracoesChart) this.declaracoesChart.destroy();
  
          this.impostosChart = new Chart(ctxImpostos2D, {
            type: 'bar',
            data: {
              labels: impostosLabels,
              datasets: [
                {
                  label: 'Entregues',
                  backgroundColor: '#87CEEB', // Azul Sky
                  borderColor: '#00BFFF', // Azul Sky
                  borderWidth: 1,
                  hoverBackgroundColor: '#00BFFF', // Azul Sky escuro
                  data: impostosEntregues
                },
                {
                  label: 'Não Entregues',
                  backgroundColor: '#F87171', // Vermelho claro
                  borderColor: '#EF4444', // Vermelho
                  borderWidth: 1,
                  hoverBackgroundColor: '#EF4444', // Vermelho escuro
                  data: impostosNaoEntregues
                }
              ]
            },
            options: {
              responsive: true,
              animation: {
                duration: 1000, // Duração da animação em milissegundos
                easing: 'easeInOutQuad' // Efeito de animação
              },
              plugins: {
                legend: {
                  labels: {
                    color: '#E5E7EB', // Texto branco
                    font: {
                      size: 14
                    }
                  }
                }
              },
              scales: {
                x: {
                  stacked: true,
                  barPercentage: 0.5,
                  categoryPercentage: 0.5,
                  ticks: {
                    color: '#E5E7EB' // Texto branco
                  }
                },
                y: {
                  stacked: true,
                  ticks: {
                    color: '#E5E7EB' // Texto branco
                  }
                }
              }
            }
          });
  
          this.declaracoesChart = new Chart(ctxDeclaracoes2D, {
            type: 'bar',
            data: {
              labels: declaracoesLabels,
              datasets: [
                {
                  label: 'Entregues',
                  backgroundColor: '#87CEEB', // Azul Sky
                  borderColor: '#00BFFF', // Azul Sky
                  borderWidth: 1,
                  hoverBackgroundColor: '#00BFFF', // Azul Sky escuro
                  data: declaracoesEntregues
                },
                {
                  label: 'Não Entregues',
                  backgroundColor: '#F87171', // Vermelho claro
                  borderColor: '#EF4444', // Vermelho
                  borderWidth: 1,
                  hoverBackgroundColor: '#EF4444', // Vermelho escuro
                  data: declaracoesNaoEntregues
                }
              ]
            },
            options: {
              responsive: true,
              animation: {
                duration: 1000, // Duração da animação em milissegundos
                easing: 'easeInOutQuad' // Efeito de animação
              },
              plugins: {
                legend: {
                  labels: {
                    color: '#E5E7EB', // Texto branco
                    font: {
                      size: 14
                    }
                  }
                }
              },
              scales: {
                x: {
                  stacked: true,
                  barPercentage: 0.5,
                  categoryPercentage: 0.5,
                  ticks: {
                    color: '#E5E7EB' // Texto branco
                  }
                },
                y: {
                  stacked: true,
                  ticks: {
                    color: '#E5E7EB' // Texto branco
                  }
                }
              }
            }
          });
        });
      }
    },
    watch: {
      showModal(newValue) {
        if (newValue) {
          document.body.style.overflow = 'hidden'; // Desativar o scroll da página
        } else {
          document.body.style.overflow = ''; // Restaurar o scroll da página
        }
      }
    }
  };
  </script>
  
  <style scoped>
  #dashboard {
    margin: 0;
    padding: 2rem;
    background-color: #1a202c; /* Fundo escuro */
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
    color: #f7fafc; /* Texto branco */
  }
  
  .filters {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 1.5rem;
    gap: 1rem; /* Espaçamento entre os filtros */
  }
  
  .filter-label {
    margin-right: 0.5rem;
    font-weight: 600;
    color: #e2e8f0; /* Texto branco */
  }
  
  .filter-select {
    padding: 0.5rem;
    background-color: #2d3748; /* Fundo escuro */
    border: none;
    border-radius: 8px;
    color: #f7fafc; /* Texto branco */
    transition: background-color 0.3s ease, transform 0.2s ease;
    cursor: pointer;
  }
  
  .filter-select:focus {
    outline: none;
    box-shadow: 0 0 0 2px #63b3ed; /* Borda azul */
    background-color: #4a5568; /* Fundo mais claro ao focar */
    transform: scale(1.05); /* Leve aumento ao focar */
  }
  
  .animated {
    animation: fadeInUp 0.5s ease-in-out;
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  @media (min-width: 768px) {
    .grid {
      grid-template-columns: 1fr 1fr;
    }
  }
  
  .chart-container {
    background-color: #2d3748; /* Fundo escuro */
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .chart-container:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Sombra mais forte ao pairar */
  }
  
  .chart-title {
    margin-bottom: 1.5rem;
    color: #f7fafc;
    font-size: 1.875rem;
    font-weight: 700;
    text-align: center;
  }
  
  .chart-canvas {
    width: 100% !important;
    height: 300px !important; /* Ajustando a altura do gráfico */
  }
  
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px); /* Adiciona o efeito de desfoque */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    animation: fadeIn 0.5s ease-in-out;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  .modal-container {
    background-color: #1f2937;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    color: #f7fafc;
    width: 90%;
    max-width: 500px;
    text-align: center;
    animation: slideDown 0.5s ease-in-out;
  }
  
  @keyframes slideDown {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }
  
  .modal-header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
  }
  
  .modal-icon {
    margin-right: 0.5rem;
    font-size: 1.875rem; /* Tamanho do ícone */
    color: #0b99eb; /* Cor do ícone */
  }
  
  .modal-title {
    font-size: 1.875rem;
    font-weight: 700;
  }
  
  .modal-filters {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  
  .modal-actions {
    display: flex;
    justify-content: center;
  }
  
  .modal-button {
    padding: 0.5rem 1rem;
    background-color: #0b99eb;
    border: none;
    border-radius: 8px;
    color: #f7fafc;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }
  
  .modal-button:hover {
    background-color: #055596;
    transform: scale(1.05);
  }
  
  ::placeholder {
    color: #a0aec0;
    opacity: 1;
  }
  
  .text-red-500 {
    color: #ef4444; /* Vermelho */
  }
  </style>
  