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


        

        $this->render($response, 'kontroler.twig', compact('baza', 'tabela'));
    }

    public function postKontroler($request, $response)
    {
//         $model = new Izbor();
//         $izbor = $model->find(1);
//         $baza = $izbor->baza;
//         $tabela = $izbor->tabela;
//         $tip = "KONTROLER";
//         $napomena = "Kontroler.";

//         $ime = snakeToCamel($tabela);

//         $rezultat = "<?php
// namespace App\\Controllers;

// use App\\Models\\{$ime};

// class {$ime}Controller extends Controller
// {";

//         $rezultat .= $this->dodajListuGET($tabela);
//         $rezultat .= $this->dodajDetaljGET($tabela);
//         // $rezultat .= $this->dodajPretraguGET();
//         // $rezultat .= $this->dodajPretraguPOST();
//         // $rezultat .= $this->dodajDodavanjeGET();
//         // $rezultat .= $this->dodajDodavanjePOST();
//         // $rezultat .= $this->dodajIzmenuGET();
//         // $rezultat .= $this->dodajIzmenuPOST();
//         // $rezultat .= $this->dodajBrisanjePOST();

//         $rezultat .= "\n}";
//         $this->render($response, 'rezultat.twig', compact('baza', 'tabela', 'tip', 'rezultat', 'napomena'));
    }

    // private function dodajListuGET($tabela)
    // {
    //     $ime_model = snakeToCamel($tabela);

    //     $rez = "
    // public function getLista(\$request, \$response)
    // {
    //     \$model = new {$ime_model}();
    //     \$lista = \$model->paginate(\$this->page(), 'page');

    //     \$this->render(\$response, '{$tabela}/lista.twig', compact('lista'));
    // }\n";

    //     return $rez;
    // }

    // private function dodajDetaljGET($tabela)
    // {
    //     $ime_model = snakeToCamel($tabela);

    //     $rez = "
    // public function getDetalj(\$request, \$response, \$args)
    // {
    //     \$id = (int) \$args['id'];
    //     \$model = new {$ime_model}();
    //     \$podaci = \$model->find(\$id);

    //     \$this->render(\$response, '{$tabela}/detalj.twig', compact('podaci'));
    // }\n";

    //     return $rez;
    // }

    // private function dodajPretraguGET($tabela)
    // {
    //     // JBG
    // }

    // private function dodajPretraguPOST($tabela)
    // {
    //     $ime = strtoupper($tabela);

    //     $rez = "
    // public function postPretraga(\$request, \$response)
    // {
    //     \$_SESSION['DATA_{$ime}_PRETRAGA'] = \$request->getParams();

    //     return \$response->withRedirect(\$this->router->pathFor('{$tabela}.pretraga.get'));
    // }\n";

    //     return $rez;
    // }
}
