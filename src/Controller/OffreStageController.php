<?php

namespace App\Controller;

use App\Entity\OffreStage;
use App\Form\OffreStageType;
use App\Repository\OffreStageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/offre')]
class OffreStageController extends AbstractController
{
    #[Route('/', name: 'admin_offre_index', methods: ['GET'])]
    public function index(OffreStageRepository $offreStageRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/offre_stage/index.html.twig', [
            'offres' => $offreStageRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'admin_offre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $offre = new OffreStage();
        $form = $this->createForm(OffreStageType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('admin_offre_index');
        }

        return $this->render('admin/offre_stage/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_offre_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(OffreStage $offre): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/offre_stage/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_offre_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, OffreStage $offre, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(OffreStageType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_offre_index');
        }

        return $this->render('admin/offre_stage/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_offre_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, OffreStage $offre, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $offre->getId(), $request->request->get('_token'))) {
            $em->remove($offre);
            $em->flush();
        }
        return $this->redirectToRoute('admin_offre_index');
    }

    #[Route('/{id}/validate', name: 'admin_offre_validate', requirements: ['id' => '\d+'], methods: ['POST'])]
    #[ParamConverter('offre', class: OffreStage::class)]
    public function validate(Request $request, OffreStage $offre, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('validate' . $offre->getId(), $request->request->get('_token'))) {
            $offre->setValidee(true);
            $em->flush();
        }
        return $this->redirectToRoute('admin_offre_index');
    }
}
