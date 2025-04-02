<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Line;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;

class LineServices{

    public function __construct(private EntityManagerInterface $entityManager)
    {
        
    }

    public function getImageForALine(string $line): string
    {
        // Associe chaque ligne à une image
        $images = [
            'metro1' => '/img/Ligne1Answer.png',
            'metro2' => '/img/Ligne2Answer.png',
            'metro3' => '/img/Ligne3Answer.png',
            'metro3bis' => '/img/Ligne3bisAnswer.png',
            'metro4' => '/img/Ligne4Answer.png',
            'metro5' => '/img/Ligne5Answer.png',
            'metro6' => '/img/Ligne6Answer.png',
            'metro7' => '/img/Ligne7Answer.png',
            'metro7bis' => '/img/Ligne7bisAnswer.png',
            'metro8' => '/img/Ligne8Answer.png',
            'metro9' => '/img/Ligne9Answer.png',
            'metro10' => '/img/Ligne10Answer.png',
            'metro11' => '/img/Ligne11Answer.png',
            'metro12' => '/img/Ligne12Answer.png',
            'metro13' => '/img/Ligne13Answer.png',
            'metro14' => '/img/Ligne14Answer.png',
            'metro15' => '/img/Ligne15Answer.png',
            'metro16' => '/img/Ligne16answer.png',
            'metro17' => '/img/Ligne17answer.png',
            'metro18' => '/img/Ligne18Answer.png',
            'metro19' => '/img/Ligne19Answer.png',
        ];

        // Image par défaut
        return $images[$line] ?? '/img/carteMetro.png'; 
    }

    public function addLineWithJsonFile($file):void
    {
        $jsonContent = file_get_contents($file->getPathname()); // Je dois aller chercher le contenu du fichier JSON avec son path car $file est un objet de type UploadFile
        $data = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Le fichier JSON est invalide.');
        }

        if(isset($data['idLine']) && isset($data['nameLine'])  && isset($data['stations']) && isset($data['symbol']) && isset($data['color'])){
            $line = new Line();
            $line->setIdLine($data['idLine']);
            $line->setNameLine($data['nameLine']);
            $line->setColor($data['color']);
            $line->setSymbol($data['symbol']);
            $this->entityManager->persist($line);

            foreach($data['stations'] as $stationData){
                $station = new Station();
                $station->setNameStation($stationData['nameStation']);
                $station->setAxisX($stationData['axisX']);
                $station->setAxisY($stationData['axisY']);
                $station->setLine($line);
                $this->entityManager->persist($station);
            }

        $this->entityManager->flush();
    }
    }
}
?>