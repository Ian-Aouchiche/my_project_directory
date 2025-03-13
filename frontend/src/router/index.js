import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import ProjectList from '../components/ProjectList.vue';
import ProjectDetails from '../views/ProjectDetails.vue';


const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/projects', name: 'projects', component: ProjectList },
  { path: '/projects/:id', name: 'project-details', component: ProjectDetails }

];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
