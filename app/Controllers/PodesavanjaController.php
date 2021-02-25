<?php

namespace App\Controllers;

use App\Models\Izbor;
use App\Models\Kolone;

class PodesavanjaController extends Controller
{
    public function getPodesavanja($request, $response)
    {
        $model = new Kolone();
        $kolone = $model->all();
        $modelI = new Izbor();
        $izbor = $modelI->find(1);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;

        $this->render($response, 'podesavanja.twig', compact('baza', 'tabela', 'kolone'));
    }

    public function postPodesavanja($request, $response)
    {
        $data = $this->data();
        
        $validacija = isset($data['validacija']) ? $data['validacija'] : null;
        $pretraga = isset($data['pretraga']) ? $data['pretraga'] : null;
        $dodavanje = isset($data['dodavanje']) ? $data['dodavanje'] : null;
        $izmena = isset($data['izmena']) ? $data['izmena'] : null;

        $model = new Kolone();
        $kolone = $model->all();

        foreach ($kolone as $k) {
            $v = ($validacija != null && in_array($k->id, $validacija)) ? 1 : 0;
            $p = ($pretraga != null && in_array($k->id, $pretraga)) ? 1 : 0;
            $d = ($dodavanje != null && in_array($k->id, $dodavanje)) ? 1 : 0;
            $i = ($izmena != null && in_array($k->id, $izmena)) ? 1 : 0;
            
            $data = [
                'validacija' => $v,
                'pretraga' => $p,
                'dodavanje' => $d,
                'izmena' => $i,
            ];
            
            $model->update($data, $k->id);
        }
        
        return $response->withRedirect($this->router->pathFor('pocetna'));
    }
}
