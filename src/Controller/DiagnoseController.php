<?php

namespace App\Controller;
use App\Entity\Diagnose;
use App\Form\DiagnoseType;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DiagnoseController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     * @throws \Exception
     */
    public function upload(Request $request)
    {
        $diag = new Diagnose();

        $form = $this->createForm(DiagnoseType::class, $diag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form['image']->getData();

            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

                // Upload l'image dans le bon repertoire
                try {
                    $imgFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Si quelque chose arrive pendant l'upload
                }

                $diag->setDate($form['date']->getData());
                $diag->setDiagnoseType($form['diagnoseType']->getData());
                $diag->setPatientName($form['patientName']->getData());
                $diag->setPatientAge($form['patientAge']->getData());
                $diag->setDentistName($form['dentistName']->getData());
                $diag->setObservations($form['observations']->getData());

                // On sauvegarde le nom du nouveau fichier uploadé
                $diag->setImage('upload/'.$newFilename);
            }

            // Sauvegarde du diagnostic en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($diag);
            $entityManager->flush();

            return $this->redirectToRoute('list_show', array('id' => $diag->getId()));
        }

        return $this->render('diagnose/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function list(Request $request)
    {
        $form = $this->createForm(SearchType::class);

        // Si une recherche est demandée
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form['search']->getData();

            $diagnoses = $this->getDoctrine()
                ->getRepository(Diagnose::class)
                ->searchQuery($criteria);

            return $this->render('diagnose/list.html.twig', [
                'form' => $form->createView(),
                'diagnoses' => $diagnoses
            ]);
        }

        // Tri des diagnostics du plus récent au plus ancien
        $diagnoses = $this->getDoctrine()
            ->getRepository(Diagnose::class)
            ->findBy(array(), array('date' => 'DESC'));

        return $this->render('diagnose/list.html.twig', [
            'form' => $form->createView(),
            'diagnoses' => $diagnoses
        ]);
    }

    /**
     * @Route("/liste/diag-{id}", name="list_show")
     */
    public function show($id)
    {
        $diagnose = $this->getDoctrine()
            ->getRepository(Diagnose::class)
            ->find($id);

        // Si le diagnostic n'existe pas, on renvoie sur une page d'erreur
        if (!$diagnose) {
            return $this->render('errors/404.html.twig');
        }

        return $this->render('diagnose/show.html.twig', [
            'diag' => $diagnose
        ]);

    }

    /**
     * @Route("/liste/delete-diag-{id}", name="diag_delete")
     */
    public function delete($id)
    {
        $diagnose = $this->getDoctrine()
            ->getRepository(Diagnose::class)
            ->find($id);

        // Si le diagnostic n'existe pas, on renvoie sur une page d'erreur
        if (!$diagnose) {
            return $this->render('errors/404.html.twig');
        }

        // Suppression de la photo associée dans le repertoire upload
        $filename = $diagnose->getImage();
        $filesystem = new Filesystem();
        $filesystem->remove($filename);

        // Suppression en base
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($diagnose);
        $entityManager->flush();

        return $this->redirectToRoute('liste');

    }

    /**
     * @Route("/liste/edit-diag-{id}", name="diag_edit")
     */
    public function edit($id, Request $request)
    {
        $diag = $this->getDoctrine()
            ->getRepository(Diagnose::class)
            ->find($id);

        // Si le diagnostic n'existe pas, on renvoie sur une page d'erreur
        if (!$diag) {
            return $this->render('errors/404.html.twig');
        }

        $form = $this->createForm(DiagnoseType::class, $diag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form['image']->getData();

            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

                // Upload l'image dans le bon repertoire
                try {
                    $imgFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Si quelque chose arrive pendant l'upload
                }

                $diag->setDate($form['date']->getData());
                $diag->setDiagnoseType($form['diagnoseType']->getData());
                $diag->setPatientName($form['patientName']->getData());
                $diag->setPatientAge($form['patientAge']->getData());
                $diag->setDentistName($form['dentistName']->getData());
                $diag->setObservations($form['observations']->getData());

                // On sauvegarde le nom du nouveau fichier uploadé
                $diag->setImage('upload/'.$newFilename);
            }

            // Sauvegarde du changement en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($diag);
            $entityManager->flush();

            return $this->redirectToRoute('list_show', array('id' => $diag->getId()));
        }

        return $this->render('diagnose/edit.html.twig', [
            'form' => $form->createView(),
            'diag' => $diag
        ]);

    }

}
