<?php

namespace App\Controller;
use App\Entity\Diagnose;
use App\Form\DiagnoseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */
    public function upload(Request $request)
    {
        $diag = new Diagnose();

        $form = $this->createForm(DiagnoseType::class, $diag);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $form['image']->getData();

            // this condition is needed because the 'img' field is not required
            // so the JPG/PNG file must be processed only when a file is uploaded
            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

                // Move the file to the directory where img are stored
                try {
                    $imgFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $diag->setDate($form['date']->getData());
                $diag->setDiagnoseType($form['diagnoseType']->getData());
                $diag->setPatientName($form['patientName']->getData());
                $diag->setPatientAge($form['patientAge']->getData());
                $diag->setDentistName($form['dentistName']->getData());
                $diag->setObservations($form['observations']->getData());

                // updates the 'imgFilename' property to store the PDF file name
                // instead of its contents
                $diag->setImage('upload/'.$newFilename);
            }

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
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
    public function list()
    {
        $diagnoses = $this->getDoctrine()
            ->getRepository(Diagnose::class)
            ->findAll();

        if (!$diagnoses) {
            throw $this->createNotFoundException(
                'Nothing found in database'
            );
        }
        return $this->render('diagnose/list.html.twig', ['diagnoses' => $diagnoses]);
    }

    /**
     * @Route("/liste/{id}", name="list_show")
     */
    public function show($id)
    {
        $diagnose = $this->getDoctrine()
            ->getRepository(Diagnose::class)
            ->find($id);

        if (!$diagnose) {
            throw $this->createNotFoundException(
                'No workout found for id '.$id
            );
        }

        return $this->render('diagnose/show.html.twig', [
            'diag' => $diagnose
        ]);

    }
}