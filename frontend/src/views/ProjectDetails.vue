<template>
    <div class="container">
      <h1 class="text-center text-dark">📌 Détails du Projet</h1>
  
      <div v-if="project">
        <h2>{{ project.nom }}</h2>
        <p><strong>Client :</strong> {{ project.client }}</p>
        <p><strong>Description :</strong> {{ project.description }}</p>
        <p><strong>Statut :</strong> <span :class="getStatusClass(project.statut)">{{ project.statut }}</span></p>
        <p><strong>Date de début :</strong> {{ formatDate(project.dateDebut) }}</p>
        <p><strong>Date de fin :</strong> {{ formatDate(project.dateFin) }}</p>
  
        <!-- ✅ Ajout du formulaire de modification -->
        <form @submit.prevent="updateProject">
          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" v-model="project.nom" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea v-model="project.description" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select v-model="project.statut" class="form-control">
              <option value="en cours">En cours</option>
              <option value="terminé">Terminé</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        </form>
  
        <router-link to="/projects" class="btn btn-primary mt-3">🔙 Retour</router-link>
      </div>
  
      <div v-else class="alert alert-warning">⏳ Chargement...</div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        project: null
      };
    },
    async mounted() {
      const projectId = this.$route.params.id;
      const response = await fetch(`http://127.0.0.1:8000/api/projects/${projectId}`);
      this.project = await response.json();
    },
    methods: {
      formatDate(date) {
        return new Date(date).toLocaleDateString("fr-FR", { year: 'numeric', month: 'long', day: 'numeric' });
      },
      getStatusClass(status) {
        return status === "en cours" ? "badge bg-warning text-dark" : "badge bg-success";
      },
      async updateProject() {
        const response = await fetch(`http://127.0.0.1:8000/api/projects/${this.project.id}`, {
          method: "PUT",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(this.project)
        });
  
        if (response.ok) {
          alert("✅ Projet mis à jour !");
        } else {
          alert("❌ Erreur lors de la mise à jour.");
        }
      }
    }
  };
  </script>
  