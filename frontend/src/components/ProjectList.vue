<template>
    <div class="container mt-5">
      <h1 class="text-center text-dark">📋 Liste des Projets</h1>
  
      <div v-if="projects.length === 0" class="alert alert-warning text-center">
        ⚠️ Aucun projet trouvé
      </div>
      
  
      <!-- Formulaire d'ajout de projet -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Ajouter un Nouveau Projet</h5>
          <form @submit.prevent="addProject">
            <div class="mb-3">
              <label for="nom" class="form-label">Nom du Projet</label>
              <input type="text" id="nom" class="form-control" v-model="newProject.nom" required />
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea id="description" class="form-control" v-model="newProject.description" required></textarea>
            </div>
            <div class="mb-3">
              <label for="dateDebut" class="form-label">Date de début</label>
              <input type="date" id="dateDebut" class="form-control" v-model="newProject.dateDebut" required />
            </div>
            <div class="mb-3">
              <label for="dateFin" class="form-label">Date de fin</label>
              <input type="date" id="dateFin" class="form-control" v-model="newProject.dateFin" required />
            </div>
            <div class="mb-3">
              <label for="client" class="form-label">Client</label>
              <input type="text" id="client" class="form-control" v-model="newProject.client" required />
            </div>
            <div class="mb-3">
              <label for="statut" class="form-label">Statut</label>
              <select id="statut" class="form-control" v-model="newProject.statut">
                <option value="en cours">En cours</option>
                <option value="terminé">Terminé</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ajouter Projet</button>
          </form>
        </div>
      </div>
  
      <!-- Liste des projets -->
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
              <router-link :to="{ name: 'project-details', params: { id: project.id } }" class="btn btn-info">
              👀 Voir plus
            </router-link>
              <button @click="deleteProject(project.id)" class="btn btn-danger w-100">❌ Supprimer</button>
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
        projects: [],
        newProject: {
          nom: '',
          description: '',
          dateDebut: '',
          dateFin: '',
          client: '',
          statut: 'en cours',
        }
      };
    },
    methods: {
      async fetchProjects() {
        const response = await fetch("http://127.0.0.1:8000/api/projects");
        const data = await response.json();
        this.projects = [...data];  // Met à jour la liste des projets
        console.log("Données récupérées et mises à jour :", this.projects);
      },
  
      async deleteProject(id) {
        const response = await fetch(`http://127.0.0.1:8000/api/projects/${id}`, { method: "DELETE" });
  
        if (response.ok) {
          const data = await response.json();
          console.log('Données supprimées :', data);
          this.fetchProjects();  // Rafraîchir la liste des projets après suppression
        } else {
          const error = await response.text();
          alert(`Erreur lors de la suppression : ${error}`);
        }
      },
  
      async addProject() {
        try {
          // Vérification si tous les champs sont remplis avant d'envoyer la requête
          if (!this.newProject.nom || !this.newProject.description || 
              !this.newProject.dateDebut || !this.newProject.dateFin ||
              !this.newProject.client || !this.newProject.statut) {
            alert("Erreur : Tous les champs doivent être remplis avant de créer un projet.");
            return;
          }
  
          const response = await fetch("http://127.0.0.1:8000/api/projects", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              nom: this.newProject.nom,
              description: this.newProject.description,
              dateDebut: this.newProject.dateDebut, // Format YYYY-MM-DD grâce à l'input type="date"
              dateFin: this.newProject.dateFin, // Format YYYY-MM-DD grâce à l'input type="date"
              client: this.newProject.client,
              statut: this.newProject.statut,
            }),
          });
  
          if (!response.ok) {
            let errorMessage = "Erreur inconnue";
            try {
              const error = await response.json();
              errorMessage = error.error || "Erreur inconnue";
            } catch (e) {
              console.error("Réponse du serveur non JSON");
            }
  
            console.error("Erreur lors de la création du projet :", errorMessage);
            alert(`Erreur lors de la création du projet : ${errorMessage}`);
            return;
          }
  
          await this.fetchProjects();  // Rafraîchir la liste après l'ajout
          this.resetForm();  // Réinitialiser le formulaire
  
        } catch (error) {
          console.error("Erreur réseau ou serveur :", error);
          alert("Une erreur est survenue lors de la connexion au serveur. Vérifiez votre connexion.");
        }
      },
  
      resetForm() {
        this.newProject = {
          nom: '',
          description: '',
          dateDebut: '',
          dateFin: '',
          client: '',
          statut: 'en cours',
        };
      },
  
      formatDate(date) {
        return new Date(date).toLocaleDateString("fr-FR", { year: 'numeric', month: 'long', day: 'numeric' });
      },
  
      getStatusClass(status) {
        return status === "en cours" ? "badge bg-warning text-dark" : "badge bg-success";
      }
    },
  
    mounted() {
      this.fetchProjects();  // Charger les projets dès le début
    }
  };
  </script>
  