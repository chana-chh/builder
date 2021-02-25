<?php

namespace App\Controllers;

use App\Models\Izbor;

class ModelController extends Controller
{
    public function getModel($request, $response)
    {
        $model = new Izbor();
        $izbor = $model->find(1);
        $baza = $izbor->baza;
        $tabela = $izbor->tabela;
        $belongsTo = $model->vezeOdTabele($baza, $tabela);
        $hasMany = $model->vezeKaTabeli($baza, $tabela);
        $tip = "MODEL";
        $napomena = "Ako postoji veza vise prema vise (belongsToMany),
posto je nije moguce automatski prepoznati, potrebno je rucno prepraviti metodu u modelu. [primer].
Za hasMany smisliti kako sa turimo mnozinu.";

        $rezultat = $this->napraviModel($tabela, $belongsTo, $hasMany);

        $this->render($response, 'rezultat.twig', compact('baza', 'tabela', 'tip', 'rezultat', 'napomena'));
    }

    private function napraviModel($tabela, $belongsTo, $hasMany)
    {
        $ime = snakeToCamel($tabela);

        $rez = "<?php
namespace App\\Models;

use App\\Classes\\Model;

class {$ime} extends Model
{
    protected \$table = '{$tabela}';\n";

        $rez .= $this->napraviPripada($tabela, $belongsTo);
        $rez .= $this->napraviImaVise($tabela, $hasMany);

        $rez .= "}";
        return $rez;
    }

    private function napraviPripada($tabela, $belongsTo)
    {
        $rez = "";
        foreach ($belongsTo as $b) {
            $ime_modela = snakeToCamel($b->ref_tabela);
            $ime_metode = lcfirst($ime_modela);
            $rez .= "
    public function {$ime_metode}()
    {
        return \$this->belongsTo('App\\Models\\{$ime_modela}', '{$b->kolona}');
    }\n";
        }

        return $rez;
    }

    private function napraviImaVise($tabela, $hasMany)
    {
        $rez = "";
        foreach ($hasMany as $h) {
            $ime_modela = snakeToCamel($h->tabela);
            $ime_metode = lcfirst($ime_modela);

            $rez .= "
    public function {$ime_metode}()
    {
        return \$this->hasMany('App\\Models\\{$ime_modela}', '{$h->kolona}');
    }\n";
        }

        return $rez;
    }
}
