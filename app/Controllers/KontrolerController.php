<?php

namespace App\Controllers;

use App\Models\Izbor;

class KontrolerController extends Controller
{
    public function getKontroler($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $tip = "KONTROLER";
        $napomena = "Kontroler.";
        /*
            Metode za sve rute
            - lista [GET]
            - detalj {id} [GET]
            - pretraga [GET]
            - pretraga [POST]
            - dodavanje [GET]
            - dodavanje [POST]
            - izmena {id} [GET]
            - izmena [POST]
            - brisanje [POST]
        */
        $ime = snakeToCamel($tabela);

        $rezultat = "<?php
namespace App\\Controllers;

use App\\Models\\{$ime};

class {$ime}Controller extends Controller
{";

        $rezultat .= $this->dodajListuGET($tabela);
        $rezultat .= $this->dodajDetaljGET($tabela);
        // $rezultat .= $this->dodajPretraguGET();
        // $rezultat .= $this->dodajPretraguPOST();
        // $rezultat .= $this->dodajDodavanjeGET();
        // $rezultat .= $this->dodajDodavanjePOST();
        // $rezultat .= $this->dodajIzmenuGET();
        // $rezultat .= $this->dodajIzmenuPOST();
        // $rezultat .= $this->dodajBrisanjePOST();

        $rezultat .= "\n}";
        $this->render($response, 'rezultat.twig', compact('baza', 'tabela', 'tip', 'rezultat', 'napomena'));
    }

    private function dodajListuGET($tabela)
    {
        // uvek ide paginacija

        $ime_model = snakeToCamel($tabela);

        $rez = "
    public function getLista(\$request, \$response)
    {
        \$model = new {$ime_model}();
        \$lista = \$model->paginate(\$this->page(), 'page');

        \$this->render(\$response, '{$tabela}/lista.twig', compact('lista'));
    }\n";

        return $rez;
    }

    private function dodajDetaljGET($tabela)
    {
        $ime_model = snakeToCamel($tabela);

        $rez = "
    public function getDetalj(\$request, \$response, \$args)
    {
        \$id = (int) \$args['id'];
        \$model = new {$ime_model}();
        \$podaci = \$model->find(\$id);

        \$this->render(\$response, '{$tabela}/detalj.twig', compact('podaci'));
    }\n";

        return $rez;
    }
}
