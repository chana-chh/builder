<?php

namespace App\Controllers;

use App\Models\Izbor;

class RuteController extends Controller
{
    public function getRute($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $tip = "ROUTES";
        $napomena = "U niz na kraju dodati sve nivoe korisnika koji mogu da pristupaju ovim rutama (trenutno samo admin).
    Ako vec postoji grupa sa pravima onda samo dodati rute u tu grupu.";
        $ime_kontrolera = snakeToCamel($tabela);
        $ime_rute = snakeToKebab($tabela);
        $rezultat = "\$app->group('', function () {
    \$this->get('/{$ime_rute}/lista', '\\App\\Controllers\\{$ime_kontrolera}Controller:getLista')->setName('{$tabela}.lista');
    \$this->get('/{$ime_rute}/detalj/{id}', '\\App\\Controllers\\{$ime_kontrolera}Controller:getDetalj')->setName('{$tabela}.detalj');
    \$this->get('/{$ime_rute}/pretraga', '\\App\\Controllers\\{$ime_kontrolera}Controller:getPretraga')->setName('{$tabela}.pretraga.get');
    \$this->post('/{$ime_rute}/pretraga', '\\App\\Controllers\\{$ime_kontrolera}Controller:postPretraga')->setName('{$tabela}.pretraga.post');
    \$this->get('/{$ime_rute}/dodavanje', '\\App\\Controllers\\{$ime_kontrolera}Controller:getDodavanje')->setName('{$tabela}.dodavanje.get');
    \$this->post('/{$ime_rute}/dodavanje', '\\App\\Controllers\\{$ime_kontrolera}Controller:postDodavanje')->setName('{$tabela}.dodavanje.post');
    \$this->get('/{$ime_rute}/izmena/{id}', '\\App\\Controllers\\{$ime_kontrolera}Controller:getIzmena')->setName('{$tabela}.izmena.get');
    \$this->post('/{$ime_rute}/izmena', '\\App\\Controllers\\{$ime_kontrolera}Controller:postIzmena')->setName('{$tabela}.izmena.post');
    \$this->post('/{$ime_rute}/brisanje', '\\App\\Controllers\\{$ime_kontrolera}Controller:postBrisanje')->setName('{$tabela}.brisanje');
})->add(new UserLevelMiddleware(\$container, [0]));";

        $this->render($response, 'rezultat.twig', compact('baza', 'tabela', 'tip', 'rezultat', 'napomena'));
    }
}
