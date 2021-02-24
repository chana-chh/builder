<?php

namespace App\Controllers;

use App\Models\Izbor;
use App\Models\Kolone;

class KontrolerController extends Controller
{
    public function getKontroler($request, $response)
    {
        $model = new Kolone();
        $kolone = $model->all();
        $modelI = new Izbor();
        $izbor = $modelI->find(1);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;

        $this->render($response, 'kontroler.twig', compact('baza', 'tabela', 'kolone'));
    }
}
