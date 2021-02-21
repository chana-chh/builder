<?php

namespace App\Controllers;

use App\Models\Izbor;

class PogledController extends Controller
{
    public function getPogled($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $tip = "POGLED";
        $napomena = "Pogled.";

        $rezultat = "Pogled";

        $this->render($response, 'rezultat.twig', compact('baza', 'tabela', 'tip', 'rezultat', 'napomena'));
    }
}
