<?php

namespace App\Controllers;

use App\Models\Izbor;
use App\Models\Kolone;
use App\Models\Skelet;
use App\Models\Meso;

// #namespace#  -   Modeli koji se koriste u klasi
// #tabelam#    -   Tabela malim slovima
// #tabelav#    -   Tabela pocetno veliko slovo
// #ttabelav#   -   Tabela velikim slovima
// #ostali#     -   Povezane tabele
// #empty#      -   Ako su sva polja prazna na filteru
// #sanitize#   -   SANITIZE
// #ifwhere#    -   If block za WHERE
// #pplus#      -   Dodatne promenjive za poglede
// #validacija# -   Kriterijumi za validaciju

class KontrolerController extends Controller
{
    public function getKontroler($request, $response)
    {
        $model = new Kolone();
        $kolone = $model->all();
        $datumi = $model->datumi();
        $brojke = $model->brojke();
        $sanitacija = $model->zaSanitaciju();
        $validacija = $model->validacija();
        $log = $model->log();
        $sort = $model->sortiranje();
        $modelI = new Izbor();
        $izbor = $modelI->find(1);
        $models = new Skelet();
        $sql = "SELECT * FROM skelet WHERE naziv LIKE '%kontroler%' AND sablon = 1;";
        $skelet = $models->fetch($sql)[0];
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $tabelav = snakeToCamel($tabela);
        $ttabelav = strtoupper($tabela);
        $kontroler = $skelet->sadrzaj;

        $referentne_tabele = $model->refet();
        $hasMany = $modelI->vezeKaTabeli($baza, $tabela);
        $pretraga = $model->pretraga();

        $ostali = "";
        $namespace = "use App\Models\\$tabelav;\n";
        $pplusNiz = array();

        // NAMESPACE, POVEZANI MODELI (ZA PRETRAGU), DODATNE PROMENJIVE ZA POGLEDE 
        foreach ($referentne_tabele as $h) {
            $ime_modela = snakeToCamel($h->ref_tabela);
            $namespace .= "use App\Models\\{$ime_modela};\n";
            $ostali .= "\$model_{$h->ref_tabela} = new {$ime_modela}();
        \${$h->ref_tabela}_lista = \$model_{$h->ref_tabela}->all();\n";
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
            $ifwhere .= ($dat->tip == 'time' ? "/* U PITANJU JE VREME PROVERI ME !!! */\n": "")."\t\tif (!empty(\$data['datum_{$index}']) && empty(\$data['datum_{$indexx}'])) {
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

        // VALIDACIJA
        $valid = "";
        foreach ($validacija as $val) {
            switch ($val->tip) {
                case 'int':
                    if ($val->nulabilno == 'NO' && $val->kljuc == 'UNI') {
                        $valid .= "'{$val->naziv}' => ['required' => true,\n\t 'unique' => '{$val->tabela}.{$val->naziv}'],";
                    }elseif($val->nulabilno == 'YES' && $val->kljuc == 'UNI'){
                        $valid .= "'{$val->naziv}' => ['unique' => '{$val->tabela}.{$val->naziv}'],\n\t";
                    }elseif ($val->nulabilno == 'NO' && $val->kljuc != 'UNI') {
                        $valid .= "'{$val->naziv}' => ['required' => true],\n\t";
                    }else{
                        $valid .= "/* IAKO JE ODABRANO POLJE ZA VALIDACIJU PO KRITERIJUMIMA ONA NIJE POTREBNA !!! */\n\t";
                    }
                    break;
                case 'varchar':
                    if ($val->nulabilno == 'NO' && $val->kljuc == 'UNI' && $val->duzina != null) {
                        $valid .= "'{$val->naziv}' => ['required' => true,\n\t 'unique' => '{$val->tabela}.{$val->naziv}',\n\t 'maxlen' => {$val->duzina}],\n\t";
                    }elseif($val->nulabilno == 'YES' && $val->kljuc == 'UNI' && $val->duzina != null){
                        $valid .= "'{$val->naziv}' => ['unique' => '{$val->tabela}.{$val->naziv}',\n\t 'maxlen' => {$val->duzina}],\n\t";
                    }elseif ($val->nulabilno == 'NO' && $val->kljuc != 'UNI' && $val->duzina != null) {
                        $valid .= "'{$val->naziv}' => ['required' => true],\n\t 'maxlen' => {$val->duzina}\n\t";
                    }elseif ($val->nulabilno == 'YES' && $val->kljuc != 'UNI' && $val->duzina != null) {
                        $valid .= "'{$val->naziv}' => ['maxlen' => {$val->duzina}],\n\t";
                    }else{
                        $valid .= "/* IAKO JE ODABRANO POLJE ZA VALIDACIJU PO KRITERIJUMIMA ONA NIJE POTREBNA !!! */\n\t";
                    }
                    break;
                case 'decimal':
                    if ($val->nulabilno == 'NO') {
                        $valid .= "'{$val->naziv}' => ['required' => true],\n\t";
                    }else{
                        $valid .= "/* IAKO JE ODABRANO POLJE ZA VALIDACIJU PO KRITERIJUMIMA ONA NIJE POTREBNA !!! */\n";
                    }
                    break;
            }
        }

        // IF PROVERA DA LI JE BAR JEDNO POLJE POPUNJENO NA FILTERU
        $emptyNiz = array(); 
        foreach ($pretraga as $pre) {
            $emptyNiz[] = "empty(\$data['{$pre->naziv}'])\n\t";
        }
        $empty = implode(' && ', $emptyNiz);

        // LOGOVI
        $logNiz = array(); 
        foreach ($log as $l) {
            $logNiz[] = "'{$l->naziv}'";
        }
        $logovi = implode(', ', $logNiz);

        // SORTIRANJE
        if (!empty($sort)) {
        $sortNiz = array();
        $sortiranje = " ORDER BY "; 
        foreach ($sort as $s) {
            $sortNiz[] = "{$s->naziv}";
        }
        $sr = implode(', ', $sortNiz);
        $sortiranje .= $sr;
        }

        // PROVER KOD BRISANJA DA LI POSTOJE POVEZANI MODELI
        if (!empty($hasMany)) {
            $brisanjeNiz = array();
        foreach ($hasMany as $has) {
            $brisanjeNiz[] = "count(\$faktura->{$has->tabela}()) > 0";
        }
            $stopbrisanje = implode(' || ', $brisanjeNiz);
        }

        // ZAMEN OBELEZENIH MESTA PROMENJIVIM U STRINGU IZ SKELETA
        $rezultat = str_replace(["#namespace#", "#tabelav#", "#tabelam#", "#ostali#", "#pplus#", "#ttabelav#", "#sanitize#", "#ifwhere#", "#empty#", "#validacija#", "#logovi#", "#sortiranje#", "#stopbrisanje#"],
                                [$namespace, $tabelav, $tabela, $ostali, $pplus, $ttabelav, $sanitize, $ifwhere, $empty, $valid, $logovi, $sortiranje, $stopbrisanje], $kontroler);

        // UPIS U TABELU MESO ILI IZMENA SADRZAJA
        $putanja = __DIR__;
        $naziv = $tabelav."Controler.php";
        $modelm = new Meso();
        if ($modelm->nepostoji($naziv, $putanja) == null) {
            $data['putanja'] = $putanja;
            $data['naziv'] = $naziv ;
            $data['sadrzaj'] = $rezultat;
            //Dok ne uklonim tip, jer mi ne treba!!!
            $data['tip_id'] = 2;
            $modelm->insert($data);
            $modkod = $modelm->find($modelm->lastId());
        }else{
            $id = $modelm->nepostoji($naziv, $putanja);
            $datam['sadrzaj'] = $rezultat;
            $modelm->update($datam, $id);
            $modkod = $modelm->find($id);
        }

        //PRAVLJENJE FAJLA !!!
        // $fajl = __DIR__ . '\\'.$tabelav."Controler.php";
        // file_put_contents($fajl, $rezultat);

        $this->render($response, 'kontroler.twig', compact('baza', 'tabela', 'kolone', 'modkod', 'skelet'));
    }

    public function getMesoIzmena($request, $response, $args)
    {
        $id = (int) $args['id'];
        $model = new Meso();
        $meso = $model->find($id);

        $this->render($response, 'mesoizmena.twig', compact('meso'));
    }

    public function getSkeletIzmena($request, $response, $args)
    {
        $id = (int) $args['id'];
        $model = new Skelet();
        $skelet = $model->find($id);

        $this->render($response, 'skeletizmena.twig', compact('skelet'));
    }
}
