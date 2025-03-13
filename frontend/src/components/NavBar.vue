<template>
    <nav class="navbar">
      <div class="container">
        <!-- Logo -->
        <img :src="logo" alt="J4R Echafaudages" class="logo" />
  
        <!-- Boutons de navigation -->
        <div class="nav-buttons">
          <router-link to="/" class="btn">🏠 Accueil</router-link>
          <router-link to="/projects" class="btn">📋 Gestion Projets</router-link>
          <router-link to="/login" class="btn btn-secondary">🔑 Connexion</router-link>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
  // ✅ Assure-toi que le nom du fichier est EXACTEMENT "J4R.png" dans src/assets/
  import logo from "../assets/J4R.png";
  
  export default {
    data() {
      return {
        logo,
      };
    },
  };
  </script>
  
  <style scoped>
  .navbar {
    background-color: #f8f9fa;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
  }
  
  .logo {
    height: 50px;
  }
  
  .nav-buttons {
    display: flex;
    gap: 15px;
  }
  
  .btn {
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
    color: #fff;
    background-color: #007bff;
    transition: 0.3s;
  }
  
  .btn:hover {
    background-color: #0056b3;
  }
  
  .btn-secondary {
    background-color: #6c757d;
  }
  
  .btn-secondary:hover {
    background-color: #545b62;
  }
  </style>
  