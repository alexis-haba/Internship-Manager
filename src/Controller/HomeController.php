<?php
namespace App\Controller;

use App\Repository\OffreStageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(OffreStageRepository $offreStageRepository): Response
    {
        $offres = $offreStageRepository->findBy(['validee' => true]);
        return $this->render('home/index.html.twig', [
            'offres' => $offres,
        ]);
    }
}