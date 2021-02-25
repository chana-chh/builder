<?php

namespace App\Controllers;

use App\Models\Izbor;
use App\Models\Kolone;

class HomeController extends Controller
{
    public function getHome($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);

        $this->render($response, 'home.twig', compact('izbor'));
    }

    public function getBaze($request, $response)
    {
        $model = new Izbor();
        $baze = $model->baze();

        $this->render($response, 'baze.twig', compact('baze'));
    }

    public function postBaze($request, $response)
    {
        $model = new Izbor();
        $baze = $model->update(['baza' => $request->getParam('baza'), 'tabela' => 'null'], 1);

        $sql = "TRUNCATE TABLE kolone;";
        $model->run($sql);

        return $response->withRedirect($this->router->pathFor('pocetna'));
    }

    public function getTabele($request, $response)
    {
        $model = new Izbor();
        $data = $model->find(1);
        $baza = $data->baza;
        $tabele = null;

        if ($baza != null && $baza != 'null' && $baza != '') {
            $tabele = $model->tabele($baza);
        }

        $this->render($response, 'tabele.twig', compact('baza', 'tabele'));
    }

    public function postTabele($request, $response)
    {
        $model = new Izbor();
        $model->update(['tabela' => $request->getParam('tabela')], 1);
        $podaci = $model->find(1);

        $sql = "TRUNCATE TABLE kolone;";
        $model->run($sql);

        $modelK = new Kolone();
        $kolone = $modelK->polja($podaci->baza, $podaci->tabela);
        foreach ($kolone as $kol) {
            $data = [
                'baza' => $kol->baza,
                'tabela' => $kol->tabela,
                'pozicija' => $kol->pozicija,
                'naziv' => $kol->naziv,
                'tip' => $kol->tip,
                'duzina' => $kol->duzina,
                'nulabilno' => $kol->nulabilno,
                'podrazumevano' => $kol->podrazumevano,
                'kljuc' => $kol->kljuc,
                'ref_tabela' => $kol->ref_tabela,
                'ref_kolona' => $kol->ref_kolona,
            ];
            $modelK->insert($data);
        }

        return $response->withRedirect($this->router->pathFor('pocetna'));
    }

    public function getPutanje($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);

        $this->render($response, 'putanje.twig', compact('izbor'));
    }

    public function postPutanje($request, $response)
    {
        $data=$this->data();

        $model = new Izbor();
        $model->update($data, 1);

        return $response->withRedirect($this->router->pathFor('pocetna'));
    }

    public function postReset($request, $response)
    {
        $model = new Izbor();
        $model->update(['baza' => 'null', 'tabela' => 'null', 'naziv' => 'null', 'putanja' => 'null'], 1);

        $sql = "TRUNCATE TABLE kolone;";
        $model->run($sql);

        return $response->withRedirect($this->router->pathFor('pocetna'));
    }
}
