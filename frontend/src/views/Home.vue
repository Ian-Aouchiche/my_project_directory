<template>
    <div class="container">
      <h1 class="text-center text-dark">🏠 Accueil - Liste des Projets</h1>
  
      <div v-if="projects.length === 0" class="alert alert-warning text-center">
        ⚠️ Aucun projet trouvé
      </div>
  
      <!-- Liste des projets (sans bouton Ajouter / Supprimer) -->
      <div class="row">
        <div v-for="project in projects" :key="project.id" class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><strong>{{ project.nom }}</strong></h5>
              <p class="card-text">
                <strong>Client :</strong> {{ project.client }}<br>
                <strong>Statut :</strong> <span :class="getStatusClass(project.statut)">{{ project.statut }}</span><br>
                <strong>Date de début :</strong> {{ formatDate(project.dateDebut) }}<br>
                <strong>Date de fin :</strong> {{ formatDate(project.dateFin) }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        projects: []
      };
    },
    methods: {
      async fetchProjects() {
        try {
          const response = await fetch("http://127.0.0.1:8000/api/projects");
          if (!response.ok) throw new Error("Erreur lors du chargement des projets.");
          this.projects = await response.json();
        } catch (error) {
          console.error(error);
        }
      },
      formatDate(date) {
        return new Date(date).toLocaleDateString("fr-FR", { year: 'numeric', month: 'long', day: 'numeric' });
      },
      getStatusClass(status) {
        return status === "en cours" ? "badge bg-warning text-dark" : "badge bg-success";
      }
    },
    mounted() {
      this.fetchProjects();
    }
  };
  </script>
  
  <style scoped>
  .container {
    margin-top: 20px;
  }
  </style>
  