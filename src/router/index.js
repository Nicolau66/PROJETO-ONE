import { createRouter, createWebHistory } from 'vue-router';

import HomeView from '../assets/pages/banco_de_dados/indexDb.vue';
import AboutView from '../assets/pages/banco_de_dados/cadastrar_empresa/formulario.vue';
import Index_dp_fiscal from '../assets/pages/dp_fiscal/index/index_dp_fiscal.vue';
import simples_nacional from '../assets/pages/dp_fiscal/simples_nacional/sn_declaracoes.vue';
import VerEmpresas from '../assets/pages/banco_de_dados/empresas/verEmpresas.vue';
import EditEmpresa from '../assets/pages/banco_de_dados/empresas/editEmpresa.vue';
import simples_nacional_impostos from '../assets/pages/dp_fiscal/simples_nacional/sn_impostos.vue';
import lucro_presumido from '../assets/pages/dp_fiscal/lucro_presumido/lucro_presumido_declaracoes.vue';
import lucro_presumido_impostos from '../assets/pages/dp_fiscal/lucro_presumido/lucro_presumido_impostos.vue';
import lucro_real from '../assets/pages/dp_fiscal/lucro_real/lucro_real.vue';
import lucro_real_impostos from '../assets/pages/dp_fiscal/lucro_real/lucro_real_impostos.vue';
import VincularEmpresas from '../assets/pages/banco_de_dados/fechamentos/vincular_empresas.vue';
import VincularEmpresaEspecifica from '../assets/pages/banco_de_dados/fechamentos/vincular_empresa_especifica.vue';
import mei_declaracoes from '../assets/pages/dp_fiscal/mei/mei_declaracoes.vue';
import mei_impostos from '../assets/pages/dp_fiscal/mei/mei_impostos.vue';
import cadastros from '../assets/pages/banco_de_dados/cadastro_impostos_declaracoes.vue';
import dashboard from '../assets/pages/dashboard/dashboard.vue';
import dp_pessoal from '../assets/pages/dp_pessoal/dp_pessoal_impostos.vue';
import dp_pessoal_declaracoes from '../assets/pages/dp_pessoal/dp_pessoal_declaracoes.vue';


const routes = [
  { path: '/', component: HomeView },
  { path: '/about', component: AboutView },
  { path: '/index_dp_fiscal', component: Index_dp_fiscal },
  { path: '/simples_nacional', component: simples_nacional },
  { path: '/ver_empresas', component: VerEmpresas },
  { path: '/empresas/editar/:id', name: 'editEmpresa', component: EditEmpresa, props: true },
  { path: '/simples_nacional_impostos', component: simples_nacional_impostos },
  { path: '/lucro_presumido', component: lucro_presumido },
  { path: '/lucro_presumido_impostos', component: lucro_presumido_impostos },
  { path: '/lucro_real', component: lucro_real },
  { path: '/lucro_real_impostos', component: lucro_real_impostos },
  { path: '/vincular_empresas', component: VincularEmpresas },
  { path: '/vincular-empresa-especifica', component: VincularEmpresaEspecifica },
  { path: '/mei_declaracoes', component: mei_declaracoes },
  { path: '/mei_impostos', component: mei_impostos },
  { path: '/cadastros', component: cadastros },
  { path: '/dashboard', component: dashboard },
  { path: '/dp_pessoal', component: dp_pessoal},
  { path: '/dp_pessoal_declaracoes', component: dp_pessoal_declaracoes},
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
