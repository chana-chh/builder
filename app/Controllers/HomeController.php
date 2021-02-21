<?php

namespace App\Controllers;

use App\Models\Izbor;

class HomeController extends Controller
{
    public function getHome($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $this->render($response, 'home.twig', compact('baza', 'tabela'));
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

        return $response->withRedirect($this->router->pathFor('pocetna'));
    }

    public function getTabele($request, $response)
    {
        $model = new Izbor();
        $data = $model->find(1);
        $baza = $data->baza;
        $tabele = null;

        if($baza != null && $baza != 'null' && $baza != '')
        {
            $tabele = $model->tabele($baza);
        }

        $this->render($response, 'tabele.twig', compact('baza', 'tabele'));
    }

    public function postTabele($request, $response)
    {
        $model = new Izbor();
        $model->update(['tabela' => $request->getParam('tabela')], 1);

        return $response->withRedirect($this->router->pathFor('pocetna'));
    }

    public function postReset($request, $response)
    {
        $model = new Izbor();
        $model->update(['baza' => 'null', 'tabela' => 'null'], 1);

        return $response->withRedirect($this->router->pathFor('pocetna'));

    }
}
