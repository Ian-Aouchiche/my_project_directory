<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\InterventionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api')]
class ApiController extends AbstractController
{
    // 📌 Route GET : Récupérer tous les projets
    #[Route('/projects', name: 'api_projects', methods: ['GET'])]
    public function getProjects(ProjectRepository $projectRepository): JsonResponse
    {
        $projects = $projectRepository->findAll();
        
        return $this->json($projects, Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => ['project:read']
        ]);
    }

    // 📌 Route GET : Récupérer un projet spécifique par ID
    #[Route('/projects/{id}', name: 'api_project', methods: ['GET'])]
    public function getProject(int $id, ProjectRepository $projectRepository): JsonResponse
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            return $this->json(['error' => 'Projet non trouvé'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($project, Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => ['project:read']
        ]);
    }

    // 📌 Route POST : Ajouter un projet
    #[Route('/projects', name: 'create_project', methods: ['POST'])]
    public function createProject(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom'], $data['description'], $data['dateDebut'], $data['dateFin'], $data['client'], $data['statut'])) {
            return $this->json(['error' => 'Données incomplètes'], Response::HTTP_BAD_REQUEST);
        }

        $project = new Project();
        $project->setNom($data['nom']);
        $project->setDescription($data['description']);
        $project->setDateDebut(new \DateTimeImmutable($data['dateDebut']));
        $project->setDateFin(new \DateTimeImmutable($data['dateFin']));
        $project->setClient($data['client']);
        $project->setStatut($data['statut']);

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json($project, Response::HTTP_CREATED, [], [
            AbstractNormalizer::GROUPS => ['project:read']
        ]);
    }

    #[Route('/projects/{id}', name: 'delete_project', methods: ['DELETE'])]
    public function deleteProject(int $id, ProjectRepository $projectRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $project = $projectRepository->find($id);
    
        if (!$project) {
            return $this->json(['error' => 'Projet non trouvé'], Response::HTTP_NOT_FOUND);
        }
    
        try {
            $entityManager->remove($project);
            $entityManager->flush();
            return $this->json(['message' => 'Projet supprimé'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Capture exception details and send them back in the response
            return $this->json(['error' => 'Erreur lors de la suppression du projet', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/projects/{id}', name: 'update_project', methods: ['PUT'])]
public function updateProject(int $id, Request $request, ProjectRepository $projectRepository, EntityManagerInterface $entityManager): JsonResponse
{
    $project = $projectRepository->find($id);

    if (!$project) {
        return $this->json(['error' => 'Projet non trouvé'], Response::HTTP_NOT_FOUND);
    }

    $data = json_decode($request->getContent(), true);

    if (isset($data['nom'])) $project->setNom($data['nom']);
    if (isset($data['description'])) $project->setDescription($data['description']);
    if (isset($data['statut'])) $project->setStatut($data['statut']);

    $entityManager->flush();

    return $this->json(['message' => 'Projet mis à jour avec succès'], Response::HTTP_OK);
}

    
}
