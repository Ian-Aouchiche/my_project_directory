<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ApiController extends AbstractController
{
    #[Route('/api/projects', name: 'api_projects', methods: ['GET'])]
    public function getProjects(ProjectRepository $projectRepository): JsonResponse
    {
        $projects = $projectRepository->findAll();
        
        return $this->json($projects, 200, [], [
            AbstractNormalizer::GROUPS => ['project:read']
        ]);
    }

    #[Route('/api/projects/{id}', name: 'api_project', methods: ['GET'])]
public function getProject(int $id, ProjectRepository $projectRepository): JsonResponse
{
    $project = $projectRepository->find($id);

    if (!$project) {
        return $this->json(['error' => 'Projet non trouvé'], 404);
    }

    return $this->json($project, 200, [], [
        AbstractNormalizer::GROUPS => ['project:read']
    ]);
}

}
