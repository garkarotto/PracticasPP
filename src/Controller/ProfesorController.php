<?php

namespace App\Controller;

use App\Entity\Profesor;
use App\Form\ProfesorType;
use App\Repository\ProfesorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profesor')]
class ProfesorController extends AbstractController
{
    #[Route('/', name: 'app_profesor_index', methods: ['GET'])]
    public function index(ProfesorRepository $profesorRepository): Response
    {
        return $this->render('profesor/index.html.twig', [
            'profesors' => $profesorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_profesor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $profesor = new Profesor();
        $form = $this->createForm(ProfesorType::class, $profesor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profesor);
            $entityManager->flush();

            return $this->redirectToRoute('app_profesor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profesor/new.html.twig', [
            'profesor' => $profesor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profesor_show', methods: ['GET'])]
    public function show(Profesor $profesor): Response
    {
        return $this->render('profesor/show.html.twig', [
            'profesor' => $profesor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_profesor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Profesor $profesor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfesorType::class, $profesor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profesor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profesor/edit.html.twig', [
            'profesor' => $profesor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profesor_delete', methods: ['POST'])]
    public function delete(Request $request, Profesor $profesor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profesor->getId(), $request->request->get('_token'))) {
            $entityManager->remove($profesor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profesor_index', [], Response::HTTP_SEE_OTHER);
    }
}
