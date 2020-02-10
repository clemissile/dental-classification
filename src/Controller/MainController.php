<?php

namespace App\Controller;

use App\Entity\Diagnose;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getRepository(Diagnose::class);

        // On récupère le nombre total de diagnostics saisis
        $totalDiagnoses = $entityManager->totalDiagnoses();

        // On récupère l'âge moyen des patients
        $avgPatientAge = $entityManager->avgPatientAge();

        // On récupère le nombre de diagnostics à catégoriser
        $nbEmptyDiagnoses = $entityManager->nbEmptyDiagnoses();

        // On récupère le nombre de diagnostics par type
        $diagByType = $entityManager->diagnosesByType();

        return $this->render('main/index.html.twig', [
            'total' => $totalDiagnoses,
            'avgage' => $avgPatientAge,
            'emptydiag' => $nbEmptyDiagnoses,
            'diagtype' => $diagByType
        ]);
    }

    /**
     * @Route("/a-propos", name="apropos")
     */
    public function apropos()
    {
        return $this->render('main/apropos.html.twig');
    }
}
