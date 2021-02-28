<?php

namespace App\Controllers;

use App\Models\Izbor;
use App\Models\Kolone;
use App\Models\Skelet;

// #namespace#  -   Modeli koji se koriste u klasi
// #tabelam#    -   Tabela malim slovima
// #tabelav#    -   Tabela pocetno veliko slovo
// #ttabelav#   -   Tabela velikim slovima
// #ostali#     -   Povezane tabele
// #empty#      -   Ako su sva polja prazna na filteru
// #procenat#   -   String ukloni space - prazno
// #sanitize#   -   SANITIZE
// #ifwhere#    -   If block za WHERE
// #pplus#      -   Dodatne promenjive za poglede

class KontrolerController extends Controller
{
    public function getKontroler($request, $response)
    {
        $model = new Kolone();
        $kolone = $model->all();
        $modelI = new Izbor();
        $izbor = $modelI->find(1);
        $models = new Skelet();
        $skelet = $models->find(6);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $tabelav = snakeToCamel($tabela);

//         $kontroler = "<?php

// namespace App\Controllers;

// use App\Classes\Auth;
// use App\Classes\Logger;
// use App\Models\Korisnik;
// #namespace#
// class #tabelav#Controller extends Controller
// {
//     public function get#tabelav#(\$request, \$response)
//     {
//         \$query = [];
//         parse_str(\$request->getUri()->getQuery(), \$query);
//         \$page = isset(\$query['page']) ? (int)\$query['page'] : 1;

//         \$model = new #tabelav#();
//         $#tabelam#_lista = \$model->paginate(\$page, 'page', 
//             \"SELECT * FROM {\$model->getTable()}\");

//         #ostali#
//         \$this->render(\$response, '#tabelam#/lista.twig', compact(#tabelam#_lista, #pplus#));
//     }
// }";  
        $kontroler = $skelet->sadrzaj;

        $hasMany = $modelI->vezeKaTabeli($baza, $tabela);

        $ostali = "";
        $namespace = "use App\Models\\$tabelav;\n";
        $pplusNiz = array();

        foreach ($hasMany as $h) {
            $ime_modela = snakeToCamel($h->tabela);
            $namespace .= "use App\Models\\{$ime_modela};\n";
            $ostali .= "\$model_{$h->tabela} = new {$ime_modela}();\n\${$h->tabela}_lista = \$model_{$h->tabela}->all();\n";
            $pplusNiz[] = "$h->tabela"."_lista";
        }

        $pplus = implode(', ', $pplusNiz);

        $ns = str_replace("#namespace#", $namespace, $kontroler);
        $tv = str_replace("#tabelav#", $tabelav, $ns);
        $tm = str_replace("#tabelam#", $tabela, $tv);
        $os = str_replace("#ostali#", $ostali, $tm);
        $rezultat = str_replace("#pplus#", $pplus, $os);
        // $fajl = __DIR__ . '\\'.$tabelav."Controler.php";
        // file_put_contents($fajl, $rezultat);

        $this->render($response, 'kontroler.twig', compact('baza', 'tabela', 'kolone', 'rezultat'));
    }
}
