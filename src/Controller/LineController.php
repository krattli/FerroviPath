<?php

namespace App\Controller;

use App\Form\AddLineType;
use App\Entity\Line;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class LineController extends AbstractController
{
    #[Route('/line/add', name: 'ferrovipath_add_line', methods:['GET','POST'])]
    public function addLine(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddLineType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('lineFile')->getData();

            if($file){
                $jsonContent = file_get_contents($file->getPathname()); // Je dois aller chercher le contenu du fichier JSON avec son path car $file est un objet de type UploadFile
                $data = json_decode($jsonContent, true);

                if(isset($data['idLine']) && isset($data['nameLine'])  && isset($data['stations'])){
                    $line = new Line();
                    $line->setNameLine($data['nameLine']);
                    $entityManager->persist($line);

                    foreach($data['stations'] as $stationData){
                        $station = new Station();
                        $station->setNameStation($stationData['nameStation']);
                        $station->setAxisX($stationData['axisX']);
                        $station->setAxisY($stationData['axisY']);
                        $station->setLine($line);
                        $entityManager->persist($station);
                    }

                    $entityManager->flush();
                }
                return $this->redirectToRoute('ferrovipath_homepage', []);
            }

        }
        return $this->render('line/index.html.twig', [
            'controller_name' => 'LineController',
        ]);
    }
}
