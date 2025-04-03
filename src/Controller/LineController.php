<?php

namespace App\Controller;

use App\Form\AddLineType;
use App\Service\LineServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class LineController extends AbstractController
{

    public function __construct(private LineServices $lineServices)
    {
        
    }

    #[Route('/line/add', name: 'ferrovipath_line_add', methods:['GET','POST'])]
    public function addLine(Request $request): Response
    {
        $form = $this->createForm(AddLineType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                try{
                    $this->lineServices->addLineWithJsonFile($form->get('lineFile')->getData());
                    $this->addFlash('success', 'La ligne de métro a bien été ajouté avec succès !');
                    return $this->redirectToRoute('ferrovipath_homepage');
                }
                catch(\InvalidArgumentException $e){
                    $this->addFlash('danger', $e->getMessage());
                    return $this->redirectToRoute('ferrovipath_line_add');
                }
            }
        return $this->render('line/add.html.twig', [
            'addLineForm' => $form->createView()
        ]);
    }
}
