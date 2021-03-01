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
// #sanitize#   -   SANITIZE
// #ifwhere#    -   If block za WHERE
// #pplus#      -   Dodatne promenjive za poglede

class KontrolerController extends Controller
{
    public function getKontroler($request, $response)
    {
        $model = new Kolone();
        $kolone = $model->all();
        $datumi = $model->datumi();
        $brojke = $model->brojke();
        $sanitacija = $model->zaSanitaciju();
        $modelI = new Izbor();
        $izbor = $modelI->find(1);
        $models = new Skelet();
        $skelet = $models->find(6);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $tabelav = snakeToCamel($tabela);
        $ttabelav = strtoupper($tabela);
        $kontroler = $skelet->sadrzaj;

        $referentne_tabele = $model->refet();
        $pretraga = $model->pretraga();

        $ostali = "";
        $namespace = "use App\Models\\$tabelav;\n";
        $pplusNiz = array();

        // NAMESPACE, POVEZANI MODELI (ZA PRETRAGU), DODATNE PROMENJIVE ZA POGLEDE 
        foreach ($referentne_tabele as $h) {
            $ime_modela = snakeToCamel($h->ref_tabela);
            $namespace .= "use App\Models\\{$ime_modela};\n";
            $ostali .= "\$model_{$h->ref_tabela} = new {$ime_modela}();\n\${$h->ref_tabela}_lista = \$model_{$h->ref_tabela}->all();\n";
            $pplusNiz[] = "'"."$h->ref_tabela"."_lista'";
        }

        $pplus = implode(', ', $pplusNiz);
        if (!empty($pplusNiz)) {
            $pplus = ", ".$pplus;
        }

        // PUNJENJE WHERE ZA PRETRAGU STRINGOVNIM VREDNOSTIMA (VARCHAR, TEXT) I SANITACIJA STRINGA
        $sanitize = "";
        $ifwhere = "";
        foreach ($sanitacija as $san) {
            $sanitize .= "\t\$data['{$san->naziv}'] = str_replace('%', '', \$data['{$san->naziv}']);
            \t\${$san->naziv} = '%' . filter_var(\$data['{$san->naziv}'], FILTER_SANITIZE_STRING) . '%';\n";
            $ifwhere .= "if (!empty(\$data['{$san->naziv}'])) {
            if (\$where !== \" WHERE \") {
                \$where .= \" AND \";
            }
            \$where .= \"{$san->naziv} LIKE :{$san->naziv}\";
            \$params[':{$san->naziv}'] = \${$san->naziv};
        }\n\n";
        }

        // PUNJENJE WHERE ZA PRETRAGU DATUMIMA (TIME, DATE, TIMESTAMP)
        if (!empty($datumi)) {

        $index = 1;
        $indexx = 2;
        foreach ($datumi as $dat) {
            $ifwhere .= ($dat->tip == 'time' ? "// U PITANJU JE VREME PROVERI ME !!!\n": "")."\t\tif (!empty(\$data['datum_{$index}']) && empty(\$data['datum_{$indexx}'])) {
            if (\$where !== \" WHERE \") {
                \$where .= \" AND \";
            }
            \$where .= \"DATE({$dat->naziv}) = :datum_{$index}\";
            \$params[':datum_{$index}'] = \$data['datum_{$index}'];
        }

        if (!empty(\$data['datum_{$index}']) && !empty(\$data['datum_{$indexx}'])) {
            if (\$where !== \" WHERE \") {
                \$where .= \" AND \";
            }
            \$where .= \"DATE({$dat->naziv}) >= :datum_{$index} AND DATE({$dat->naziv}) <= :datum_{$indexx} \";
            \$params[':datum_{$index}'] = \$data['datum_{$index}'];
            \$params[':datum_{$indexx}'] = \$data['datum_{$indexx}'];
        }\n\n";
        $index+=2;
        $indexx+=2;
        }

        }
        
        // PUNJENJE WHERE ZA PRETRAGU BROJKAMA (INT, DECIMAL)
        if (!empty($brojke)) {
            foreach ($brojke as $broj) {
            $ifwhere .= "\tif (!empty(\$data['{$broj->naziv}'])) {
            if (\$where !== \" WHERE \") {
            \$where .= \" AND \";
            }
            \$where .= \"{$broj->naziv} = :{$broj->naziv}\";
            \$params[':{$broj->naziv}'] = \$data['{$broj->naziv}'];
            }\n\n";
            }
        }

        // IF PROVERA DA LI JE BAR JEDNO POLJE POPUNJENO NA FILTERU
        $emptyNiz = array(); 
        foreach ($pretraga as $pre) {
            $emptyNiz[] = "empty(\$data['{$pre->naziv}'])\n";
        }
        $empty = implode(' && ', $emptyNiz);

        // ZAMEN OBELEZENIH MESTA PROMENJIVIM U STRINGU IZ SKELETA
        $rezultat = str_replace(["#namespace#", "#tabelav#", "#tabelam#", "#ostali#", "#pplus#", "#ttabelav#", "#sanitize#", "#ifwhere#", "#empty#"],
                                [$namespace, $tabelav, $tabela, $ostali, $pplus, $ttabelav, $sanitize, $ifwhere, $empty], $kontroler);

        // $fajl = __DIR__ . '\\'.$tabelav."Controler.php";
        // file_put_contents($fajl, $rezultat);

        $this->render($response, 'kontroler.twig', compact('baza', 'tabela', 'kolone', 'rezultat'));
    }
}
