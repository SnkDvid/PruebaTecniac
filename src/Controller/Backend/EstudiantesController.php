<?php

namespace App\Controller\Backend;

use App\Entity\Estudiantes;
use Knp\Snappy\Pdf;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstudiantesController extends AbstractController
{
    //funcion de index ppgina principal
    #[Route('/backend/estudiantes', name: 'estudiantes')]
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiantes = $repository->findBy(['habilitado' => 0]); //traer todos los estudiantes de la db
        return $this->render('backend/estudiantes/index.html.twig', [
            'estudiantes' => $estudiantes,
        ]);
    }

    //funcion de crear estudiantes
    #[Route('/backend/estudiantes/crear', name: 'estudiantes_crear')]
    public function crear(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response {
        if($request->isMethod('POST')){
            $estudiante = new Estudiantes();
            $estudiante->setNombre($request->request->get('nombre'));
            $estudiante->SetSalon($request->request->get('salon'));
            $estudiante->setAcudiente($request->request->get('acudiente'));
            $estudiante->setEdad((int)$request->request->get('edad'));
            $estudiante->setGenero($request->request->get('genero'));
            //persistir para guardar en la base de datos
            $entityManager->persist($estudiante);
            $entityManager->flush();
            //redireccionar a la vista de todos los estudiantes con un mensaje de exito
            $this->addFlash('exito', 'El Estudiante se ha Registrado exitosamente, y ahora puedes descargar un PDF');
            return $this->redirectToRoute('estudiantes');
        }
            //buscamos todos los estudiantes en bd
            $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
            $estudiantes = $repository->findBy(['habilitado' => 0]);
            //retornamos la vista con los estudiantes
            return $this->render('backend/estudiantes/index.html.twig', [
                'estudiantes' => $estudiantes,
            ]);
    }

    //funcion de editar estudiantes
    #[Route('/backend/estudiantes/editar/{id}', name: 'estudiantes_editar')]
    public function editar(Request $request, EntityManagerInterface $entityManager, $id): Response{
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiante = $repository->find($id); 
        if($request->isMethod('POST')){
            $estudiante->SetNombre($request->request->get('nombre'));
            $estudiante->setSalon($request->request->get('salon'));
            $estudiante->SetAcudiente($request->request->get('acudiente'));
            $estudiante->SetEdad((int)$request->request->get('edad')); 
            $estudiante->SetGenero($request->request->get('genero'));
            $entityManager->flush();
            $this->addFlash('exito', 'El Estudiante se ha actualizado exitosamente');
            return $this->redirectToRoute('estudiantes');
        }
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiantes = $repository->findBy(['habilitado' => 0]);
        
        return $this->render('backend/estudiantes/index.html.twig', [
            'estudiantes' => $estudiantes,
        ]);
    }

    //funcion para inhabilitar estudiantes
    #[Route('/backend/estudiantes/inhabilitar/{id}', name: 'estudiantes_inhabilitar')]
    public function inhabilitar($id, EntityManagerInterface $entityManager): Response{
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiante = $repository->find($id);
        if($estudiante->getHabilitado('habilitado') == 0){
            $estudiante->setHabilitado(1);
            $entityManager->flush();
            $this->addFlash('exito', 'El Estudiante se ha inhabilitado exitosamente');
            return $this->redirectToRoute('estudiantes');
    }
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiantes = $repository->findBy(['habilitado' => 0]);
        return $this->render('backend/estudiantes/index.html.twig', [
            'estudiantes' => $estudiantes,
        ]);
    }
        //funcion para habilitar estudiantes
    #[Route('/backend/estudiantes/habilitar/{id}', name: 'estudiantes_habilitar')]
    public function habilitar($id, EntityManagerInterface $entityManager): Response{
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiante = $repository->find($id);
        if($estudiante->getHabilitado('habilitado') == 1){
            $estudiante->setHabilitado(0);
            $entityManager->flush();
            $this->addFlash('exito', 'El Estudiante se ha Activado exitosamente');
            return $this->redirectToRoute('estudiantes');
    }
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiantes = $repository->findBy(['habilitado' => 0]);
        return $this->render('backend/estudiantes/index.html.twig', [
            'estudiantes' => $estudiantes,
        ]);
    }
    //funcion para ver estudiantes ihhabilitados
    #[Route('/backend/estudiantes/habilitados', name: 'estudiantes_inhabilitados')]
    public function inhabilitados(): Response{
        $repository = $this->getDoctrine()->getRepository(Estudiantes::class);
        $estudiantes = $repository->findBy(['habilitado' => 1]); 
        return $this->render('backend/estudiantes/inhabilitados.html.twig', [
            'estudiantes' => $estudiantes,
        ]);
    }

    //funcion para descargar pdfy verlos
    #[Route('/backend/estudiantes/pdf', name: 'estudiantes_pdf')]
    public function pdf(pdf $knpSnappypdf, EntityManagerInterface $entityManager): Response{
        $repository = $entityManager->getRepository(Estudiantes::class);
        $estudiantes = $repository->findBy(['habilitado' => 0]);

        $html = $this->renderView('backend/estudiantes/pdf.html.twig', [
            'estudiantes' => $estudiantes,
        ]);

        $pdfContent = $knpSnappypdf->getOutputFromHtml($html, [
        ]);

        return new Response(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="estudiantes.pdf"',
            ]
        );
    }

}