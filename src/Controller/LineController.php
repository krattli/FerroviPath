<?php

namespace App\Controller;

use App\Entity\Line;
use App\Entity\Station;
use App\Form\AddLineType;
use App\Form\LineFormBuilder;
use App\Form\LineTypeManual;
use App\Service\LineServices;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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

    #[Route('/line/add-manually', name: 'ferrovipath_add_manually', methods: ['GET', 'POST'])]
    public function addLineManually(Request $request, EntityManagerInterface $em, LineFormBuilder $formBuilder): Response
    {
        $step = $request->query->get('step', 1);
        $lineData = [
            'nameLine' => $request->query->get('nameLine', ''),
            'color' => $request->query->get('color', ''),
            'symbol' => $request->query->get('symbol', ''),
            'stationCount' => $request->query->get('stationCount', 0),
        ];

        $form = $formBuilder->build($step, $lineData, $request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($step === 1) {
                $formData = $form->getData();
                return $this->redirectToRoute('ferrovipath_add_manually', [
                    'step' => 2,
                    'nameLine' => $formData['nameLine'],
                    'color' => $formData['color'],
                    'symbol' => $formData['symbol'],
                    'stationCount' => $formData['stationCount'],
                ]);
            }
            $line = $form->getData();
            $formBuilder->persistLineWithStations($line, $em);

            return $this->redirectToRoute('ferrovipath_homepage');
        }

        return $this->render($step === 1 ? 'line/add-manually-step1.html.twig' : 'line/add-manually-step2.html.twig', [
            'form' => $form->createView(),
            'lineData' => $lineData
        ]);
    }
}
