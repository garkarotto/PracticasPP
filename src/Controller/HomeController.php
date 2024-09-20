<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(AlumnoRepository $AlumnoRepository): Response
    {
        $alumnos = $AlumnoRepository->findALL();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'alumnos' => $alumnos,
        ]);
    }
}
