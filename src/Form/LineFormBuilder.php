<?php

namespace App\Form;

use App\Entity\Line;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class LineFormBuilder extends FormBuilder{
    public function __construct(private FormFactoryInterface $formFactory) {}

    public function build(int $step, array $lineData, Request $request): FormInterface
    {
        if ($step === 1) {
            $form = $this->formFactory->createBuilder()
                ->add('nameLine', TextType::class, ['label' => 'Nom',])
                ->add('color', TextType::class, ['label' => 'Couleur',])
                ->add('symbol', TextType::class, ['label' => 'Symbole',])
                ->add('stationCount', IntegerType::class, ['label' => 'Nombre de stations'])
                ->getForm();
        } else {
            $line = new Line();
            $line->setNameLine($lineData['nameLine']);
            $line->setColor($lineData['color']);
            $line->setSymbol($lineData['symbol']);

            for ($i = 0; $i < $lineData['stationCount']; $i++) {
                $station = new Station();
                $line->addStation($station);
            }

            $formBuilder = $this->formFactory->createBuilder(LineTypeManual::class, $line);

            // On enlève les champs relatifs à la ligne dans l'étape 2 pour pas qu'ils s'affichent, on les a déjà remplis
            $formBuilder->remove('nameLine');
            $formBuilder->remove('color');
            $formBuilder->remove('symbol');

            $form = $formBuilder->getForm();
        }

        $form->handleRequest($request);
        return $form;
    }

    public function persistLineWithStations(Line $line, EntityManagerInterface $em): void
    {
        foreach ($line->getStations() as $station) {
            $station->setLine($line);
            $em->persist($station);
        }

        $em->persist($line);
        $em->flush();
    }
}