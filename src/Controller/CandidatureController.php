<?php
namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\OffreStage;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/postuler/{id}', name: 'candidature_postuler', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function postuler(Request $request, OffreStage $offre, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $candidature = new Candidature();
        $candidature->setOffre($offre);
        $candidature->setUser($this->getUser());

        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($candidature);
            $em->flush();
            $this->addFlash('success', 'Candidature soumise avec succès !');
            return $this->redirectToRoute('mes_candidatures');
        }

        return $this->render('candidature/postuler.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mes-candidatures', name: 'mes_candidatures', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function mesCandidatures(): Response
    {
        $candidatures = $this->getUser()->getCandidatures();
        return $this->render('candidature/mes_candidatures.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }

    #[Route('/admin/candidatures', name: 'admin_candidatures', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function adminCandidatures(Request $request, CandidatureRepository $candidatureRepository, EntityManagerInterface $em): Response
    {
        $candidatures = $candidatureRepository->findAll();

        if ($request->isMethod('POST')) {
            $candidatureId = $request->request->get('candidature_id');
            $newStatus = $request->request->get('status');
            $candidature = $candidatureRepository->find($candidatureId);

            if ($candidature) {
                $candidature->setStatut($newStatus);
                $em->flush();
                $this->addFlash('success', 'Statut mis à jour avec succès !');
            }
            return $this->redirectToRoute('admin_candidatures');
        }

        return $this->render('candidature/admin_candidatures.html.twig', [
            'candidatures' => $candidatures,
        ]);
    }
}