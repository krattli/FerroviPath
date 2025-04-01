<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\LineRepository;

class GlobalVariableLine{

    public function __construct(private LineRepository $LineRepository){

    }

    public function getLines(){
        return $this->LineRepository->findAll();
    }

}

?>